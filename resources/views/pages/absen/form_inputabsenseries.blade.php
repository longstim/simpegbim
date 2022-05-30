@extends('layouts.dashboard')
@section('page_heading','Input Data Absen Series')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{url('pasien')}}">Pasien</a></li>
  <li class="breadcrumb-item active">Tambah Pasien</li>
</ol>
@endsection
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
  <!-- jquery validation -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tambah Data</h3>
      </div>
        <div>
          @if(Session::has('message'))
              <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
              <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
          @endif
        </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form role="form" id="inputabsenseries" method="post" action="{{url('prosesabsenseries')}}" >
        {{ csrf_field() }}
  
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
                <label>Nama</label>
                <select name="nama" class="form-control select2bs4" style="width: 100%;">
                        <option value="" selected="selected">-- Pilih Satu --</option>
                        @foreach($pegawai as $data)
                            <option value="{{$data->nip}}">{{$data->nama}}</option>
                        @endforeach
                    </select>
              </div>
              <div class="form-group">
                <label>Tanggal Mulai</label>
                <div class="input-group date">
                    <input type="text" name="tanggal_mulai" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                 </div>
              </div>
              <div class="form-group">
                <label>Tanggal Selesai</label>
                <div class="input-group date">
                    <input type="text" name="tanggal_selesai" class="form-control" id="datepicker2" placeholder="dd/mm/yyyy" value="{{date('d/m/Y', strtotime(now()))}}">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                 </div>
              </div>
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control select2bs4" style="width: 100%;">
                        <option value="" selected="selected">-- Pilih Satu --</option>
                        <option value="S">Sakit</option>
                        <option value="I">Izin</option>
                        <option value="D">Dinas</option>
                        <option value="CT">Cuti Tahunan</option>
                        <option value="CKAP">Cuti Karena Alasan Penting</option>
                        <option value="CS">Cuti Sakit</option>
                        <option value="CM">Cuti Bersalin</option>
                        <option value="CB">Cuti Besar</option>
                        <option value="CLTN">Cuti di Luar Tanggungan Negara</option>
                 </select>
              </div>

              <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control" id="txtKeterangan" placeholder="Keterangan">
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
    $('#inputabsenseries').validate({
      rules: {
        nama: {
          required: true
        },
        tanggal_mulai: {
          required: true
        },
        tanggal_selesai: {
          required: true
        },
        status: {
          required: true,
        },
        keterangan: {
          required: true
        },
      },
      messages: {
        nama: {
          required: "Nama harus dipilih."
        },
        tanggal_mulai: {
          required: "Tanggal Mulai harus diisi."
        },
        tanggal_selesai: {
          required: "Tanggal Selesai harus diisi."
        },
        status: {
          required: "Status harus diisi.",
        },
        keterangan: {
          required: "Keterangan harus diisi."
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

      //Date picker
      $('#datepicker2').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
      })

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