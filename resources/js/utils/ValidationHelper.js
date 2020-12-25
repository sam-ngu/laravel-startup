
const emailValidator = (input) => {
    return (!input ? true :  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(input) ) || 'Incorrect format'  // 99% email regex
};

const phoneValidator = (input) => {
    return ( !input ? true : /((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/.test(input) ) || "Incorrect format."
};

const passwordRules = [
    v => !!v || "Required",
    v => (v && v.length >= 8) || "Password must be at least 8 characters",
    v => (v && /[a-z]/.test(v)) || "Password must contain lowercase",
    v => (v && /[A-Z]/.test(v)) || "Password must contain uppercase",
    v => (v && /[0-9]/.test(v)) || "Password must contain number",
    v => (v && /[@$!%*#?&]/.test(v)) || "Password must contain special characters",
];


export {
    passwordRules,
    emailValidator,
    phoneValidator,
}
