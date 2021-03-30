
/*
* Helper function to show user the current status
* Message type could be 'success' 'error' 'info', "warning"
* Info is pretty printed JSON to display as swal body
* * */
const swalTimer = (messageType, timer=1500, info) => {
    let title = messageType.toUpperCase();
    if(_.isEmpty(info))
        info = "";

    return swal.fire({
        title: title,
        type: messageType,
        showCancelButton: false,
        showConfirmButton: true,
        confirmButtonText: 'Okay',
        confirmButtonClass: 'success',
        buttonsStyling: true,
        timer: timer,
        html:"<pre><code>" + info + "</code></pre>",
    }).then(function (result) {
        if(result.value){ //confirm
            return;
        }
        if(result.dismiss === swal.DismissReason.cancel){ //cancel
            return;
        }
    });
};

const swalMessage = (messageType, info) => {
    let title = messageType.toUpperCase();
    if(_.isEmpty(info)){
        info = "";
    }

    function createList(items){
        const ul = document.createElement('ul');
        for (let ii = 0; ii < items.length; ii++){
            const item = items[ii];
            const li = document.createElement('li');
            li.setAttribute('style', 'list-style: none');
            li.textContent = item;
            ul.appendChild(li);
        }
        return ul;
    }


    if(info instanceof Object){
        console.log({info});
        info = createList(Object.values(info)).innerHTML;
        console.log({info});
        // let payload = '';
        // for (const key in info) {
        //     payload += info[key] + '\n'
        // }
        // info = payload;
    }

    return swal.fire({
        title: title,
        type: messageType,
        showCancelButton: false,
        confirmButtonText: 'Okay',
        confirmButtonClass: 'success',
        buttonsStyling: true,
        // html:"<pre><code>" + info + "</code></pre>",
        html: info,
    }).then(function (result) {
        if(result.value){ //confirm
            return;
        }
    });
}

const swalLoader = (info) => {
    if(_.isEmpty(info))
        info = "";

    return swal.fire({
        title: "Loading",
        showCancelButton: false,
        showConfirmButton: false,
        buttonsStyling: true,
        html:"<pre><code>" + info + "</code></pre>",
        onBeforeOpen(){
            swal.showLoading()
        }
    }).then(function (result) {
        if(result.value){ //confirm
            return;
        }
    });
}

const swalConfirm = (html="", confirmCallback, rejectCallback) => {
    return swal.fire({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        confirmButtonClass: 'success',
        cancelButtonClass: 'error',
        buttonsStyling: true,
        html:html,
        cancelButtonText: 'No'
    }).then(function (result) {
        if(result.value){ //confirm
            if(confirmCallback){
                confirmCallback();
            }
            return;
        }
        if(result.dismiss === swal.DismissReason.cancel){ //cancel
            if(rejectCallback){
                rejectCallback();
            }
            return;
        }
    });
};

export {
    swalConfirm,
    swalLoader,
    swalMessage,
    swalTimer
}
