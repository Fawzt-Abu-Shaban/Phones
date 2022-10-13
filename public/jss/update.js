function update(url, id , data , redirectroute) {
            axios.put(url + '/' + id, data)
                .then(function(response) {
                    // handle success 2xx
                    console.log(response);
                    if (redirectroute != undefined) {
                    window.location.href = redirectroute;
                    }else{
                        toastr.success(response.data.message)
                    }
                })
                .catch(function(error) {
                    // handle error 4xx , 5xx
                    console.log(error);
                    toastr.error(error.response.data.message)

                });
        }
