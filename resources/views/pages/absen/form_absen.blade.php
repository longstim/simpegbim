@extends('layouts.dashboard')
@section('page_heading','Absensi: '.$absen['tanggal'])
@section('content')
  <!-- Main content -->
   <div class="row">
      <div class="col-md-12">
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif

         <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:30%">Nama</th>
                <td>{{$absen['nama']}}</td>
              </tr>
              <tr>
                <th style="width:30%">NIP</th>
                <td>{{$absen['nip']}}</td>
              </tr>
              <tr>
                <th style="width:30%">Waktu Masuk</th>
                <td>{{$absen['waktu_masuk']}} WIB</td>
              </tr>
              <tr>
                <th style="width:30%">Waktu Pulang</th>
                <td>{{$absen['waktu_pulang']}} WIB</td>
              </tr>
            </table>
        </div>
        <hr/>
 
          <button class="btn btn-primary" onclick="checkRadius()">Absen</button>
      </div>
    </div> 
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('assets/geo-location-javascript/js/geo-min.js')}}"></script>
<script>

    function checkRadius()
    {
      if(geo_position_js.init()){
        geo_position_js.getCurrentPosition(success_callback,error_callback,{enableHighAccuracy:true});
      }
      else{
        alert("Functionality not available");
      }
    }

    function success_callback(p)
    {
      if(p.coords.latitude!="" && p.coords.longitude!="")
      {

         $rad = calRadius(p.coords.latitude, p.coords.longitude);

         window.location.href = 'prosesabsen/' + $rad;
      }
      else
      {
         alert("Koordinat tidak ditemukan.")
      }
    }
    
    function error_callback(p)
    {
      alert('error='+p.message);
    } 
    
    function calRadius(latCur, longCur)
    {
      // var R = 6.371; // km
      var R = 6371000;

          latBIM = 3.568948600750669;
          longBIM = 98.69060561164635;

      var dLat = toRad(latCur-latBIM);
      var dLon = toRad(longCur-longBIM);
      var lat1 = toRad(latBIM);
      var lat2 = toRad(latCur);

      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      var d = R * c;
      return d;
    }

    // Converts numeric degrees to radians
    function toRad(Value)
    {
        return Value * Math.PI / 180;
    } 

  </script>
  <script type="text/javascript">
    $( document ).ready(function () {

      //SweetAlert Success
      var message = $("#idmessage").val();
      var message_text = $("#idmessage_text").val();

      if(message_text=="Absen berhasil")
      {
        Swal.fire({     
           icon: 'success',
           title: 'Success!',
           text: message_text,
           showConfirmButton: false,
           timer: 1500
        })
      }
      else if(message_text=="Absen gagal. Anda tidak sedang berada di lokasi Kantor Baristand Industri Medan")
      {
         Swal.fire({     
           icon: 'error',
           title: 'Failed!',
           text: message_text,
           showConfirmButton: false,
           timer: 1500
         })
      }

      //SweetAlert Delete
     $(document).on("click", ".swalDelete",function(event) {  
        event.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
          title: 'Apakah anda yakin menghapus data ini?',
          text: 'Anda tidak akan dapat mengembalikan data ini!',
          icon: 'error',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
        if (result.value) 
        {
            window.location.href = url;
        }
      });
    });
  });
  </script>
@endsection
