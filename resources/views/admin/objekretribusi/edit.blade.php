         <form action="/admin/objekretribusi/{{Crypt::encrypt($data->id_ojk)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
         <input type="hidden" name="kode_lama" value="{{ $data->kode_ojk }}" class="form-control input-default" required>
             <div class="mb-3">
                 <label class="form-label">Kode Akun :</label>
                 <input type="text" name="kode" pattern="[0-9\.]+" value="{{ $data->kode_ojk }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Nama Akun :</label>
                 <input type="text" name="nama" value="{{ $data->nama_ojk }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Jenis Retribusi :</label>
                 <select class="default-select  form-control wide mt-3" name="select2" id="select2" >
                 <option value="">Pilih Jenis</option>
                 @foreach ($jenis as $d)
                 <option {{ $data->id_jr == $d->id_jr ? 'selected' : '' }}
                 value="{{ $d->id_jr }}">{{$d->kode_jr }} {{ ($d->nama_jr) }}
                 </option>
                 @endforeach
                 </select>
             </div>
             <div class="mb-3">
                 <label class="form-label">Sub Retribusi :</label>
                 <select class="default-select  form-control wide mt-3" name="sub2" id="sub2" >
                 <option value="">Pilih Sub Retribusi</option>
                 @foreach ($subj as $d)
                 <option {{ $data->id_sr == $d->id_sr ? 'selected' : '' }}
                 value="{{ $d->id_sr }}">{{$d->kode_sr }} {{ ($d->nama_sr) }}
                 </option>
                 @endforeach
                 </select>
             </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
