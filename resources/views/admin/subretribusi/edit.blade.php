         <form action="/admin/jenisretribusi/{{Crypt::encrypt($tb_jr->id_jr)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
         <input type="hidden" name="kode_lama" value="{{ $tb_jr->kode_jr }}" class="form-control input-default" required>
             <div class="mb-3">
                 <label class="form-label">Kode Akun :</label>
                 <input type="text" name="kode" value="{{ $tb_jr->kode_jr }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Nama Akun :</label>
                 <input type="text" name="nama" value="{{ $tb_jr->nama_jr }}" class="form-control input-default" required>
             </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
