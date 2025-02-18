         <form action="/admin/operator/{{Crypt::encrypt($tb_operator->id_operator)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
             <div class="mb-3">
                 <label class="form-label">Username :</label>
                 <input type="text" name="username" value="{{ $tb_operator->username }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Nama Pejabat/Kepala SKPD/UPTD :</label>
                 <select class="default-select  form-control wide mt-3" name="id_agency" >
                 <option value="">Pilih SKPD/UPTD</option>
                 @foreach ($tb_agency as $d)
                 <option {{ $tb_operator->id_agency == $d->id_agency ? 'selected' : '' }}
                 value="{{ $d->id_agency }}">{{ ($d->nama_agency) }}
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
