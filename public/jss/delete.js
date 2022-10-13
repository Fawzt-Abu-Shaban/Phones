function confirmDestroy(url, id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    conformDelete(url, id, reference);
                }
            })
        }

        function conformDelete(url, id, reference) {
            axios.delete(url + '/' + id)
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    showMessage(response.data);
                    reference.closest('tr').remove();
                })
                .catch(function(error) {
                    // handle error 4xx , 5xx
                    console.log(error);
                    showMessage(error.response.data);
                });
        }

        function showMessage(data) {
            Swal.fire({
                // position: 'top-end',
                icon: data.icon,
                title: data.title,
                showConfirmButton: false,
                timer: 1500
            })
        }
