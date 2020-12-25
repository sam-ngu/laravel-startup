import {swalMessage} from "./SwalHelper";

/*Helper function to catch error returned by axios, afterCallback function accept the response object
*
* */
const axiosErrorCallback = (response, afterCallback) => {
    let errors = response.response.data.errors;
    if ((typeof errors) === "string")
        errors = {errors};
    swal.close();
    swalMessage("error", errors);
    if (_.isFunction(afterCallback)){
        afterCallback(response)
    }
};

export {axiosErrorCallback}
