// @ts-expect-error package is not available as a source in a composer installation
import Notification from '@typo3/backend/notification.js';

class Sessionplaner {
  constructor() {
    document.querySelectorAll<HTMLElement>('[data-sessionplaner-draggable="true"]').forEach((element: HTMLElement) => {
      element.addEventListener('dragstart', (event: DragEvent) => {
        const target = event.target as HTMLElement;
        const session = {
          uid: target.dataset.sessionUid
        };
        if (event.dataTransfer) {
          event.dataTransfer.setData('application/json', JSON.stringify(session));
          event.dataTransfer.effectAllowed = 'move';
        }
      });
    });

    document.querySelectorAll<HTMLElement>('[data-sessionplaner-dragtarget]').forEach((element: HTMLElement) => {
      element.addEventListener('dragleave', (event: DragEvent) => {
        event.stopPropagation();
        element.classList.remove('dragtarget');
      }, { capture: true, passive: true });

      element.addEventListener('dragover', (event: DragEvent) => {
        event.stopPropagation();
        const type = element.dataset.sessionplanerDragtarget;
        let allowDrop = false;
        if (type === 'slot' && element.children.length === 0) {
          allowDrop = true;
        } else if (type === 'stash') {
          allowDrop = true;
        }
        if (allowDrop) {
          event.preventDefault();
          if (event.dataTransfer) {
            event.dataTransfer.dropEffect = 'move';
          }
          element.classList.add('dragtarget');
        }
      }, { capture: true });

      element.addEventListener('drop', (event: DragEvent) => {
        event.stopPropagation();
        element.classList.remove('dragtarget');
        const target = event.target as HTMLElement;
        const session = JSON.parse(event.dataTransfer?.getData('application/json') ?? '{}');
        const sessionElement = document.querySelector<HTMLElement>('[data-session-uid="' + session.uid + '"]');
        if (sessionElement) {
          this.updateSession(sessionElement, {
            room: target.dataset.roomUid ?? null,
            slot: target.dataset.slotUid ?? null,
            day: target.dataset.dayUid ?? null,
          });
        }
      });
    });
  }

  updateSession(element: HTMLElement, data: {room: string | null, slot: string | null, day: string | null}) {
    const endpoint = 'evoweb_sessionplaner_update';
    const payload = {
      session: {
        uid: element.dataset.sessionUid,
        room: data.room ?? null,
        slot: data.slot ?? null,
        day: data.day ?? null,
      }
    };
    this.postData(endpoint, payload).then((response) => {
      if (response.status === 'success') {
        element.dataset.sessionRoom = response.data.session.room ?? null;
        element.dataset.sessionSlot = response.data.session.slot ?? null;
        element.dataset.sessionDay = response.data.session.day ?? null;
        this.updateSessionPosition(element);
      } else {
        Notification.error('Error', response.message);
      }
    });
  }

  updateSessionPosition(element: HTMLElement) {
    let slotSelector = '';
    slotSelector += '[data-sessionplaner-dragtarget="slot"]';
    slotSelector += '[data-room-uid="' + element.dataset.sessionRoom + '"]';
    slotSelector += '[data-slot-uid="' + element.dataset.sessionSlot + '"]';
    slotSelector += '[data-slot-uid="' + element.dataset.sessionSlot + '"]';

    const slotElement = document.querySelector(slotSelector);
    const stashElement = document.querySelector('[data-sessionplaner-dragtarget="stash"]');

    if (slotElement) {
      slotElement.append(element);
    } else if (stashElement) {
      stashElement.append(element);
    }
  }

  async postData(endpoint: string = '', data = {}) {
    const response = await fetch(TYPO3.settings.ajaxUrls[endpoint], {
      method: 'POST',
      cache: 'no-cache',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    });
    return response.json();
  }
}

new Sessionplaner();
