#!/bin/bash

export NC='\e[0m'
export RED='\e[0;31m'
export GREEN='\e[0;32m'

THIS_SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" >/dev/null && pwd)"
cd "$THIS_SCRIPT_DIR" || exit 1

#################################################
# Run resource tests.
# Arguments:
#   none
#################################################
checkResources () {
    clear
    echo "#################################################################" >&2
    echo " Checking Documentation, TypeScript and Scss files" >&2
    echo "#################################################################" >&2
    echo "" >&2

    ./runTests.sh -s lintScss
    EXIT_CODE_SCSS=$?

#    ./runTests.sh -s lintTypescript
#    EXIT_CODE_TYPESCRIPT=$?

    ./runTests.sh -s checkRstRenderingSingle
    EXIT_CODE_DOCUMENTATION=$?

    echo "#################################################################" >&2
    echo " Checked Documentation, TypeScript and Scss files" >&2
    if [[ ${EXIT_CODE_SCSS} -eq 0 ]] && \
        [[ ${EXIT_CODE_TYPESCRIPT} -eq 0 ]] && \
        [[ ${EXIT_CODE_DOCUMENTATION} -eq 0 ]]
    then
        echo -e "${GREEN}Resources valid${NC}" >&2
    else
        echo -e "${RED}Resources invalid${NC}" >&2
        exit 1
    fi
    echo "#################################################################" >&2
    echo "" >&2

    ./runTests.sh -s clean
}

#################################################
# Run test matrix.
# Arguments:
#   php version
#   typo3 version
#   testing framework version
#   test path
#   prefer lowest
#################################################
runFunctionalTests () {
    local PHP_VERSION="${1}"
    local TYPO3_VERSION=${2}
    local TESTING_FRAMEWORK=${3}
    local TEST_PATH=${4}
    local PREFER_LOWEST=${5}

    clear
    echo "###########################################################################" >&2
    echo " Run unit and/or functional tests with" >&2
    echo " - TYPO3 ${TYPO3_VERSION}" >&2
    echo " - PHP ${PHP_VERSION}">&2
    echo " - Testing framework ${TESTING_FRAMEWORK}">&2
    echo " - Test path ${TEST_PATH}">&2
    echo " - Additional ${PREFER_LOWEST}">&2
    echo "###########################################################################" >&2
    echo "" >&2

    ./runTests.sh \
        -p ${PHP_VERSION} \
        -s lintPhp || exit 1 ; \
        EXIT_CODE_LINT=$?

    ./runTests.sh \
        -p ${PHP_VERSION} \
        -s composer require ${PREFER_LOWEST} "typo3/cms-core:${TYPO3_VERSION}" || exit 1 ; \
        EXIT_CODE_CORE=$?

#    ./runTests.sh \
#        -p ${PHP_VERSION} \
#        -s composer require --dev ${PREFER_LOWEST} "typo3/testing-framework:${TESTING_FRAMEWORK}" || exit 1 ; \
#        EXIT_CODE_FRAMEWORK=$?

    ./runTests.sh \
        -p ${PHP_VERSION} \
        -s composerValidate || exit 1 ; \
        EXIT_CODE_VALIDATE=$?

    ./runTests.sh \
        -p ${PHP_VERSION} \
        -s cgl || exit 1 ; \
        EXIT_CODE_CGL=$?

    ./runTests.sh \
        -p ${PHP_VERSION} \
        -s phpstan || exit 1 ; \
        EXIT_CODE_PHPSTAN=$?

    ./runTests.sh \
        -p ${PHP_VERSION} \
        -n -s normalizeXliff || exit 1 ; \
        EXIT_CODE_XLIFF=$?

#    ./runTests.sh \
#        -p ${PHP_VERSION} \
#        -s unit Tests/Unit || exit 1 ; \
#        EXIT_CODE_UNIT=$?
#
#    ./runTests.sh \
#        -p ${PHP_VERSION} \
#        -d sqlite \
#        -s functional ${TEST_PATH} || exit 1 ; \
#        EXIT_CODE_FUNCTIONAL=$?

    echo "###########################################################################" >&2
    echo " Finished unit and/or functional tests with" >&2
    echo " - TYPO3 ${TYPO3_VERSION}" >&2
    echo " - PHP ${PHP_VERSION}">&2
    echo " - Testing framework ${TESTING_FRAMEWORK}">&2
    echo " - Test path ${TEST_PATH}">&2
    echo " - Additional ${PREFER_LOWEST}">&2
    if [[ ${EXIT_CODE_LINT} -eq 0 ]] && \
        [[ ${EXIT_CODE_CORE} -eq 0 ]] && \
        [[ ${EXIT_CODE_FRAMEWORK} -eq 0 ]] && \
        [[ ${EXIT_CODE_VALIDATE} -eq 0 ]] && \
        [[ ${EXIT_CODE_CGL} -eq 0 ]] && \
        [[ ${EXIT_CODE_PHPSTAN} -eq 0 ]] && \
        [[ ${EXIT_CODE_XLIFF} -eq 0 ]] && \
        [[ ${EXIT_CODE_UNIT} -eq 0 ]] && \
        [[ ${EXIT_CODE_FUNCTIONAL} -eq 0 ]]
    then
        echo -e "${GREEN}SUCCESS${NC}" >&2
    else
        echo -e "${RED}FAILURE${NC}" >&2
        exit 1
    fi
    echo "#################################################################" >&2
    echo "" >&2

    ./runTests.sh -s clean
}

LOWEST="--prefer-lowest"
TPATH="Tests/Functional"

DEBUG_TESTS=false
if [[ $DEBUG_TESTS != true ]]; then
    checkResources

    TCORE="^12.4"
    TFRAMEWORK="^8.3.1"
    runFunctionalTests "8.1" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.2" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.2" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
    runFunctionalTests "8.3" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.3" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
    runFunctionalTests "8.4" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.4" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
    runFunctionalTests "8.5" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.5" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1

    TCORE="^13.4"
    TFRAMEWORK="^9.2.1"
    runFunctionalTests "8.2" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.2" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
    runFunctionalTests "8.3" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.3" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
    runFunctionalTests "8.4" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.4" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
    runFunctionalTests "8.5" ${TCORE} ${TFRAMEWORK} ${TPATH} || exit 1
    runFunctionalTests "8.5" ${TCORE} ${TFRAMEWORK} ${TPATH} ${LOWEST} || exit 1
else
    #./runTests.sh -s clean
    runFunctionalTests "8.4" "^13.4" "^9.2.1" ${TPATH} ${LOWEST} || exit 1
    # ./runTests.sh -x -p 8.2 -d sqlite -s functional -e "--group selected" Tests/Functional
    # ./runTests.sh -x -p 8.2 -d sqlite -s functional Tests/Functional
fi
