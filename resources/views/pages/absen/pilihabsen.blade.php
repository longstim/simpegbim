@extends('layouts.dashboard')
@section('page_heading','Daftar Absen')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item">Pilih Absen</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-primary">
		  <div class="card-header">
		    <h3 class="card-title">Pilih Bulan</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  <!-- /.card-header -->
		  <!-- form start -->
		  <form role="form" id="pilihabsen" method="post" action="{{url('absen')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-4">		     
			      	<div class="form-group">
				        <label>Bulan</label>
				        <select name="bulan" class="form-control select2bs4" style="width: 100%;">
		                    <option value="" selected="selected">-- Pilih Satu --</option>
		                    <option value="1">Januari</option>
		                    <option value="2">Februari</option>
		                    <option value="3">Maret</option>
		                    <option value="4">April</option>
		                    <option value="5">Mei</option>
		                    <option value="6">Juni</option>
		                    <option value="7">Juli</option>
		                    <option value="8">Agustus</option>
		                    <option value="9">September</option>
		                    <option value="10">Oktober</option>
		                    <option value="11">November</option>
												<option value="12">Desember</option>
		             </select>
							</div>
			     </div>

				    <div class="col-md-3">
			      	 <div class="form-group">
				        <label>Tahun</label>
				        <select name="tahun" class="form-control select2bs4" style="width: 100%;">
		                    <option value="" selected="selected">-- Pilih Satu --</option>
		                    <option value="2022">2022</option>
		             </select>
							</div>
					 </div>

					 <div class="col-md-3">
			      	 <div class="form-group">
				        <label>Jenis Pegawai</label>
				        <select name="jenispegawai" class="form-control select2bs4" style="width: 100%;">
		                    <option value="PNS">PNS</option>
		                    <option value="PPNPN">PPNPN</option>
		             </select>
							</div>
					 </div>
			    </div>
			</div>
			<!-- /.card-body -->

			<div class="card-footer">
		      <button type="submit" class="btn btn-primary">Tampilkan</button>
		    </div>
			
	  	</form>
		</div>
        <!-- /.row -->
	</div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {
	  $('#pilihabsen').validate({
	    rules: {
	      bulan: {
	        required: true
	      },
	      tahun: {
	        required: true
	      },
	    },
	    messages: {
	      bulan: {
	        required: "Bulan harus dipilih"
	      },
	      tahun: {
	        required: "Tahun harus dipilih"
	      },
	    },
	    errorElement: 'span',
	    errorPlacement: function (error, element) {
	      error.addClass('invalid-feedback');
	      element.closest('.form-group').append(error);
	    },
	    highlight: function (element, errorClass, validClass) {
	      $(element).addClass('is-invalid');
	    },
	    unhighlight: function (element, errorClass, validClass) {
	      $(element).removeClass('is-invalid');
	    }
	  });

	  //DataTable
      $("#detailtable").DataTable({
          "paging": true,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false,
	      "responsive": true,
      });

      //SweetAlert Success
      var message = $("#idmessage").val();
      var message_text = $("#idmessage_text").val();

      if(message=="1")
      {
        Swal.fire({     
           icon: 'success',
           title: 'Success!',
           text: message_text,
           showConfirmButton: false,
           timer: 1500
        })
      }

	});
</script>
@endsection