function store(url , data,) {
            axios.post(url + '/', data)
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    toastr.success(response.data.message)
                    document.getElementById('reset_form').reset();
                })
                .catch(function(error) {
                    // handle error 4xx , 5xx
                    console.log(error);
                    toastr.error(error.response.data.message)

                });
        }
