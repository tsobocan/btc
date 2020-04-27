<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Naloga</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="search-container">
        <div class="search">
            <label for="txid" class="search-label">ID transakcije</label>
            <div class="search-input">
                <span class="tr-icon"><i class="fas fa-fingerprint"></i></span>
                <span class="flex-grow-1 tr-input"> <input type="text" name="txid" id="txid" class="form-control"
                                                           value="0e3e2357e806b6cdb1f70b54c3a3a17b6714ee1f0e68bebb44a74b1efd512098"
                                                           placeholder="Vnesite ID transakcije"></span>
                <span class="tr-button">
                 <button class="btn btn-primary btn-sm" id="startSearch">Iskanje</button>
               </span>
            </div>
        </div>
    </div>
    <div class="search-container my-3">
        <div class="alert alertify" id="alert" style="display: none"></div>
    </div>
    <div id="results" style="display: none">
        <div class="search-container">
            <div class="options">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#raw">Raw</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="search-container">

            <div class="tab-content custom-tabs " id="myTabContent">
                <div class="tab-pane fade show active" id="raw" role="tabpanel" aria-labelledby="raw-tab"></div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
<script>
    $(document).ready(function () {
        $('#myTab a').on('click', function (e) {
            e.preventDefault()
            $(this).tab('show')
        });

        $('#startSearch').on('click', function () {
            let id = $('#txid').val();
            if (id.length != 64) {
                showError('Dolžina vnesenega IDja ni ustrezna. Zahtevana dolžina je 64 znakov.');
                return;
            }

            axios.post('/search', {
                txID: id
            })
                .then(response => response.data)
                .then(response => {
                    $('#results').hide();
                    $('#alert').hide();
                    $('#raw').empty()
                    if (response.code === 2) {
                        $('#results').show();
                        $('#raw').append('<pre>' + response.data + '</pre>');
                    } else {
                        showError(response.status)
                    }

                })
                .catch(error => {
                    showError('Prišlo je do napake.')
                });
        });

        function showError(message = 'Napaka') {
            $('#results').hide();

            $('#alert').html(message).show();
        }
    })
</script>
</body>
</html>
