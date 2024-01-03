function showLoading(param) {
    if (param == 1) {
      Swal.fire({
        title: 'Proses Menyimpan',
        html: 'Please wait...',
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });
    } else {
      Swal.close();
    }
  }