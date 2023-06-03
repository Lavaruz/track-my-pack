$.validator.setDefaults({
  highlight: function(element) {
    $(element).closest('.form-group').addClass('has-error');
  },
  unhighlight: function(element) {
    $(element).closest('.form-group').removeClass('has-error');
  },
  errorElement: 'span',
  errorClass: 'help-block',
  errorPlacement: function(error, element) {
    if (element.parent('.input-group').length) {
      error.insertAfter(element.parent());
    } else {
      error.insertAfter(element);
    }
  }
});

function swalAlert(status, message, url = '', submessage = '') {
  Swal.fire({
    icon: status,
    title: message,
    text: submessage,
    showClass: {
        popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
    },
    showConfirmButton: true,
  }).then((isConfirm) => {
      if(isConfirm) {
          if(url != '') {
              window.location.href = url;
          }
      }
  });

  return true;
}