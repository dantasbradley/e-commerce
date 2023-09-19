//this function displays alert with a success icon and the message you want
function alertSuccess(message) {
    Swal.fire({
      icon: 'success',
      title: message,
    });
  
  }
  //this function displays alert with a fail icon and the message you want
  function alertFail(message) {
    Swal.fire({
      icon: 'error',
      title: message
      
    });
  }