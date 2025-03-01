         <form action="/admin/subretribusi/{{Crypt::encrypt($data->id_sr)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
         <input type="hidden" name="kode_lama" value="{{ $data->kode_sr }}" class="form-control input-default" required>
             <div class="mb-3">
                 <label class="form-label">Kode Akun :</label>
                 <input type="text" name="kode" pattern="[0-9\.]+" value="{{ $data->kode_sr }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Nama Akun :</label>
                 <input type="text" name="nama" value="{{ $data->nama_sr }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Jenis Retribusi :</label>
                 <select class="default-select  form-control wide mt-3" name="jenis" >
                 <option value="">Pilih Jenis</option>
                 @foreach ($jenis as $d)
                 <option {{ $data->id_jr == $d->id_jr ? 'selected' : '' }}
                 value="{{ $d->id_jr }}">{{ ($d->nama_jr) }}
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
