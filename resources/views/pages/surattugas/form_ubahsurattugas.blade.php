@extends('layouts.dashboard')
@section('page_heading','Surat Tugas')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('surattugas')}}">Surat Tugas</a></li>
  <li class="breadcrumb-item active">Ubah Surat Tugas</li>
</ol>
@endsection
@section('content')
<div class="row">
	<!-- left column -->
	<div class="col-md-12">
	<!-- jquery validation -->
		<div class="card card-primary">
		  <div class="card-header">
		    <h3 class="card-title">Ubah Data</h3>
		  </div>
	      <div>
	        @if(Session::has('message'))
	            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
	            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
	        @endif
	      </div>
		  <!-- /.card-header -->
		  <!-- form start -->
		  <form role="form" id="ubahsurattugas" method="post" action="{{url('prosesubahsurattugas')}}" >
		  	{{ csrf_field() }}
	
			<div class="card-body">
				<div class="row">
				    <div class="col-md-6">
				    	<input type="hidden" name="id" class="form-control" id="txtID" value="{{$stheader->id}}"></input>

				      <div class="form-group">
				        <label>No. Surat</label>
				        <input type="text" name="no_surat" class="form-control" value="{{$stheader->no_surat}}" id="txtNoSurat" placeholder="Nomor Surat">
				      </div>
				      <div class="form-group">
				        <label>Tanggal Surat</label>
				        <div class="input-group date">
		                  <input type="text" name="tanggal_surat" class="form-control" value="{{date('d/m/Y', strtotime($stheader->tanggal_surat))}}" id="datepicker" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
		                  <div class="input-group-prepend">
		                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
		                  </div>
	                </div>
			      	</div>
			      	<div class="form-group">
				        <label>Nama Tugas</label>
				        <input type="text" name="nama_tugas" class="form-control" value="{{$stheader->nama_tugas}}" id="txtNamaTugas" placeholder="Nama Tugas">
				      </div>
				      <div class="form-group">
					        <label>Jenis Tugas</label>
					        <select name="jenis_tugas" class="form-control select2bs4" style="width: 100%;">
	                    <option value="" selected="selected">-- Pilih Satu --</option>
	                    @foreach($jenistugas as $data)
	                        <option value="{{$data->id}}" @if($data->id == $stheader->jenis_tugas) selected @endif>{{$data->jenis_tugas}}</option>
	                    @endforeach
			            </select>
					    </div>
					    <div class="form-group">
					        <label>Metode Penugasan</label>
					        <select name="metode" class="form-control select2bs4" style="width: 100%;">
	                    <option value="" selected="selected">-- Pilih Satu --</option>
	                    <option value="luring" @if($stheader->metode == "luring") selected @endif>Luring</option>
	                    <option value="daring" @if($stheader->metode == "daring") selected @endif>Daring</option>
	                    <option value="hybrid" @if($stheader->metode == "hybrid") selected @endif>Hybrid</option>
			            </select>
					    </div>
					    <div class="form-group">
				      		<label>Peserta</label>
				      		<select name="peserta[]" id="txtPeserta" class="form-control select2bs4" multiple="multiple" style="width: 100%;" data-placeholder="Pilih Peserta">
                          @foreach($pegawai as $data)
                              <option value="{{$data->id}}" @if(in_array($data->id, $daftarpegawai)) selected @endif>{{$data->nama}}</option>
                          @endforeach
                  </select>  
				      	</div>
			      </div>

				    <div class="col-md-6">
				      <div class="form-group">
				        <label>Tanggal Tugas</label>
				        <div class="row">
				        	 <div class="col-md-5">
						        <div class="input-group date">
				                  <input type="text" name="tanggal_st_awal" class="form-control" value="{{date('d/m/Y', strtotime($stheader->tanggal_tugas_awal))}}" id="datepickerawal" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
				                  <div class="input-group-prepend">
				                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
				                  </div>
			                	</div>
			                </div>
			                <div class="col-md-2">
			            		<h5>s/d</h5>
			                </div>
			                <div class="col-md-5">
			                	<div class="input-group date">
				                  <input type="text" name="tanggal_st_akhir" class="form-control" value="{{date('d/m/Y', strtotime($stheader->tanggal_tugas_akhir))}}" id="datepickerakhir" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
				                  <div class="input-group-prepend">
				                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
				                  </div>
			                	</div>
			                </div>
		                </div>
				      	</div>
				      	<div class="form-group">
					        <label>Penyelenggara</label>
					        <input type="text" name="penyelenggara" class="form-control" value="{{$stheader->penyelenggara}}" id="txtPenyelenggara" placeholder="Penyelenggara">
					      </div>
				      	<div class="form-group">
					        <div class="card">
				      	  	<div class="card-header">
				                <h4 class="card-title"><b>Yang Menandatangani</b></h4>
				            </div>
				          	<div class="card-body">
									    <div class="form-group">
									        <label>Nama</label>
									        <select name="penandatangan" class="form-control select2bs4" style="width: 100%;">
							                    <option value="" selected="selected">-- Pilih Satu --</option>
							                    @foreach($pegawai as $data)
							                        <option value="{{$data->id}}" @if($data->id == $stheader->penandatangan) selected @endif>{{$data->nama}}</option>
							                    @endforeach
							            </select>
									    </div>
									    <div class="form-group">
									        <label>Jabatan</label>
									        <input type="text" name="jabatan_penandatangan" class="form-control" value="{{$stheader->jabatan_penandatangan}}"id="txtJabatanPenandatangan" placeholder="Jabatan Yang Menandatangani">
									    </div>
										</div>
									</div>
					     </div>
						</div>
				</div>
			</div>
			<!-- /.card-body -->

			<div class="card-footer">
		      <button type="submit" class="btn btn-primary">Simpan</button>
		    </div>
			
	  	</form>
		</div>
        <!-- /.row -->
	</div>
</div>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {
	  $('#tambahkodearsip').validate({
	    rules: {
	      nama: {
	        required: true
	      },
	      nama_arsip: {
	        required: true
	      },
	      aktif: {
	        required: true,
	        number:true
	      },
	      inaktif: {
	        required: true,
	        number:true
	      },
	    },
	    messages: {
	      nama: {
	        required: "Nama Pegawai harus diisi."
	      },
	      nama_arsip: {
	        required: "Nama Arsip harus diisi."
	      },
	      aktif: {
	        required: "Aktif harus diisi.",
	        number: "Aktif harus diisi dengan angka."
	      },
	      inaktif: {
	        required: "Inaktif harus diisi.",
	        number: "Inaktif harus diisi dengan angka."
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


	  //datepicker
	  $('#datepickerawal').datepicker({
	      format: 'dd/mm/yyyy',
	      autoclose: true
		})

		$('#datepickerakhir').datepicker({
	      format: 'dd/mm/yyyy',
	      autoclose: true
		})

	});
</script>
@endsection