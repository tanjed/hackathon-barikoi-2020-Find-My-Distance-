<style>
    .card{
        margin: 5px;
    }
</style>

<div class="container">
    <center><h1 style="text-transform:uppercase;">Find My Address</h1></center>
    <hr>
    <div class="row">
        <input type="text" class="form-control" id="search_box">
    </div>
    <div class="row d-flex justify-content-center" id="result" style="margin-top: 20px;">
    </div>
</div>
<script>
    let response;
    let my_latitude = geoplugin_latitude();
    let my_longitude = geoplugin_longitude();
    let colors = ['secondary','success','danger','warning','info','dark'];
    $('#search_box').keyup(function () {
        $( "#result" ).html('');
        let query = $(this).val();
        query.length > 0 ? auto_complete(query) :  $( "#result" ).html('');
    });

    function auto_complete(query) {
        let request = $.ajax({
            url: '{{$auto_complete}}'+query,
        });
        request.done(function( msg ) {
            response = msg.places;
            for(var i = 0; i< msg.places.length; i++){

                let card = `<div class='card border-success col-md-3'
                            onclick="showDetails(${msg.places[i].id})">`+
                             `<input type="hidden" data-id="${msg.places[i].id}" id="address_id">`+
                            `  <div class="card-body">${msg.places[i].address}</div>` +

                            `</div>`;
                $( "#result" ).append(card);
            }
        });
        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

  function showDetails(id){
        let place = getPlace(id);
        let url = `https://barikoi.xyz/v1/api/distance/{{$api_key}}/${my_longitude},${my_latitude}/${place.longitude},${place.latitude}`;
      let request = $.ajax({
          url: url,
      });
      request.done(function( msg ) {
          alert('Address : ' + place.address+
              ' City : ' + place.city+
              ' Area : ' + place.area+
              ' Post Code : ' + place.postCode+
              ' Thana : '+ place.thana+
              ' District : '+place.district+
          ' Distance :'+ msg.Distance);
      });
      request.fail(function( jqXHR, textStatus ) {
          alert( "Request failed: " + textStatus );
      });

  }

    function getPlace(id) {
        for(let i = 0; i<response.length; i++){
            if(response[i].id == id){
                return response[i];
            }
        }
    }

</script>

