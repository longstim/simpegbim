@extends('layouts.dashboard')
@section('page_heading','Profil Pegawai')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
  <li class="breadcrumb-item active">Profil Pegawai</li>
</ol>
@endsection
@section('content')

<!-- Main content -->
  <div class="row">
    <div class="col-md-3">

     <!-- About Me Box -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-bordered-sm"
                 src="{{asset('image/profil/'.$pegawai->foto)}}"
                 alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{$pegawai->nama}}</h3>

          <p class="text-muted text-center">NIP. {{$pegawai->nip}}</p>

          <hr>

          <strong><i class="fas fa-birthday-cake  mr-1"></i> Tempat Tanggal Lahir</strong>
          <p class="text-muted">{{$pegawai->tempat_lahir}}, {{$pegawai->tanggallahir}}</p>

          <hr>

          <strong><i class="fas fa-certificate mr-1"></i> Pangkat/Gol.</strong>
          <p class="text-muted">{{$pegawai->pangkat}}, {{$pegawai->golongan}}</p>

          <hr>

          <strong><i class="fas fa-briefcase mr-1"></i> Jabatan</strong>
          <p class="text-muted">{{$pegawai->jabatan}}</p>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Biodata</a></li>
            <li class="nav-item"><a class="nav-link" href="#jabatan" data-toggle="tab">Jabatan</a></li>
            <li class="nav-item"><a class="nav-link" href="#pangkat" data-toggle="tab">Pangkat</a></li>
            <li class="nav-item"><a class="nav-link" href="#pendidikan" data-toggle="tab">Pendidikan</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="profil">
            
              <!-- Biodata -->
              <table class="table">
                <tr>
                  <th style="width:20%">No. KTP</th>
                  <td>:</td>
                  <td><input type="text" name="no_ktp" value="{{$pegawai->no_ktp}}" class="form-control" id="txtNoKTP" placeholder="No. KTP" readonly></td>
                </tr>
                <tr>
                  <th style="width:20%">Jenis Kelamin</th>
                  <td>:</td>
                  <td><input type="text" name="jenis_kelamin" value="{{$pegawai->jenis_kelamin}}" class="form-control" id="txtJenisKelamin" placeholder="Jenis Kelamin" readonly></td>
                </tr>
                  <th style="width:20%">Alamat</th>
                  <td>:</td>
                  <td><textarea name="alamat" class="form-control" id="txtAlamat rows="2" placeholder="Alamat" readonly="">{{$pegawai->alamat}}</textarea></td>
                </tr>
                <tr>
                  <th style="width:20%">Agama</th>
                  <td>:</td>
                   <td><input type="text" name="agama" value="{{$pegawai->agama}}" class="form-control" id="txtAgama" placeholder="Agama" readonly></td>
                </tr>
                </table>
                <!-- Biodata -->
              </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="jabatan">
              <table id="detailtable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Jabatan</th>
                      <th>Jenjang Jabatan</th>
                      <th width="100px">T.M.T</th>
                      <th width="150px">No. SK</th>
                      <th width="100px">Tanggal SK</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $no = 0
                    @endphp
                    @foreach($jabatan as $data)  
                    <tr>
                      <td>{{++$no}}</td>
                      <td>{{$data->jabatan}}</td>
                      <td>{{$data->jenjangjabatan}}</td>
                      <td>{{formatTanggalIndonesiaV2($data->tmt)}}</td>
                      <td>{{$data->no_sk}}</td>
                      <td>{{formatTanggalIndonesiaV2($data->tanggal_sk)}}</td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
                          <span class="caret"></span>
                          </button>
                          <div class="dropdown-menu" id="dropdown-action-id">
                            <a class="dropdown-item" href="ubahkodearsip/{{$data->id}}">Ubah Data</a>
                          </div>
                        </div>
                      </td>
                   </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="pangkat">
              <table id="detailtable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Pangkat</th>
                      <th>Golongan</th>
                      <th width="100px">T.M.T</th>
                      <th width="150px">No. SK</th>
                      <th width="100px">Tanggal SK</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $no = 0
                    @endphp
                    @foreach($pangkat as $data)  
                    <tr>
                      <td>{{++$no}}</td>
                      <td>{{$data->pangkat}}</td>
                      <td>{{$data->golongan}}</td>
                      <td>{{formatTanggalIndonesiaV2($data->tmt_pangkat)}}</td>
                      <td>{{$data->no_sk}}</td>
                      <td>{{formatTanggalIndonesiaV2($data->tanggal_sk)}}</td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
                          <span class="caret"></span>
                          </button>
                          <div class="dropdown-menu" id="dropdown-action-id">
                            <a class="dropdown-item" href="ubahkodearsip/{{$data->id}}">Ubah Data</a>
                          </div>
                        </div>
                      </td>
                   </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="pendidikan">
              <table id="detailtable" class="table table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Sekolah</th>
                      <th>Jurusan</th>
                      <th>Tingkat</th>
                      <th>Tahun Lulus</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $no = 0
                    @endphp
                    @foreach($pendidikan as $data)  
                    <tr>
                      <td>{{++$no}}</td>
                      <td>{{$data->nama_sekolah}}</td>
                      <td>{{$data->jurusan}}</td>
                      <td>{{$data->tingkat}}</td>
                      <td>{{$data->tahun_lulus}}</td>
                      <td>
                        <div class="btn-group">
                          <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
                          <span class="caret"></span>
                          </button>
                          <div class="dropdown-menu" id="dropdown-action-id">
                            <a class="dropdown-item" href="ubahkodearsip/{{$data->id}}">Ubah Data</a>
                          </div>
                        </div>
                      </td>
                   </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->

          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
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