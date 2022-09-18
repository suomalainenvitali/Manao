// Field validation methods

// Field validation methods
const formValidate = () => {
    return {
        // Validation of the Login
        isLoginValid: (value) => {
            if (typeof value !== "undefined") {
                let regular = /^[0-9a-zA-Z]{6,}$/;
                if (regular.test(value)) {
                    return true;
                }
            }
            return false;
        },

        // Validation of the Password
        isPasswordValid: (value) => {
            if (typeof value !== undefined) {
                let regular = /^[0-9a-zA-Z]{6,}$/;
                if (
                    regular.test(value) &&
                    value.search(/\d/) != -1 &&
                    value.search(/[A-Za-z]/) != -1
                ) {
                    return true;
                }
            }
            return false;
        },
        // Validation of the Confirm Password
        isConfirmPasswordValid(value_first, value_second) {
            if (
                typeof value_first !== undefined &&
                typeof value_first !== undefined
            ) {
                if (value_first === value_second) return true;
            }
            return false;
        },
        // Validation of the Email
        isEmailValid(value) {
            if (typeof value !== undefined) {
                let regular = /^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i;
                if (regular.test(value)) {
                    return true;
                }
            }
            return false;
        },
        // Validation of the Name
        isNameValid(value) {
            if (typeof value !== undefined) {
                let regular = /^[A-Za-zа-яА-Я]{2,30}$/;
                if (regular.test(value)) {
                    return true;
                }
            }
            return false;
        },
    };
};
