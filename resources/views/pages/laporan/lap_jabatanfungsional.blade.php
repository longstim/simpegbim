@extends('layouts.dashboard')
@section('page_heading','Daftar Jabatan Fungsional')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Daftar Jabatan Fungsional</li>
</ol>
@endsection
@section('content')
<!-- Main content -->
  <div class="row">
    <div class="col-12">
      <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
              <thead>
              <tr style="background-color:#1d809f; color:#fff">
                <th>No</th>
                <th>Nama</th>
                <th>Jumlah</th>
              </tr>
              </thead>
              <tbody>
              @php
              $no = 0
              @endphp
              @foreach($datajabfung as $data)  
                 <tr><!--data-widget="expandable-table" aria-expanded="false">-->
                    <td>{{++$no}}</td>
                    <td>{{$data->jabatan}}</td>
                    <th>{{$data->jumlah}}</th>
                 </tr>
                <!-- <tr class="expandable-body">
                      <td>
                        <div class="p-0">
                          <table class="table table-hover">
                            <tbody>
                              <tr data-widget="expandable-table" aria-expanded="false">
                                <td>
                                  219-1
                                </td>
                              </tr>
                            </tbody>
                        </table>
                      </div>
                    </td>
                     <td>
                        219-2
                      </td>
                      <td>
                        219-3
                      </td>
                  </tr>-->
              @endforeach
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div>
        @if(Session::has('message'))
            <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
            <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
        @endif
      </div>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-hover table-striped">
            <thead>
            <tr style="background-color:#1d809f; color:#fff">
              <th>No</th>
              <th>Nama</th>
              <th>NIP</th>
              <th>Pangkat</th>
              <th>Gol</th>
              <th>Jabatan</th>
              <th>Jenjang Jabatan</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($pegawai as $data)  
               <tr>
                  <td>{{++$no}}</td>
                  <td>{{$data->nama}}</td>
                  <td>{{$data->nip}}</td>
                  <td>{{$data->pangkat}}</td>
                  <td>{{$data->golongan}}</td>
                  <td>{{$data->jabatan}}</td>
                  <td>{{$data->jenjangjabatan}}</td>
               </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row -->
  <!-- /.content -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $( document ).ready(function () {

      //DataTable
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
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