         <form action="/admin/agency/{{Crypt::encrypt($tb_agency->id_agency)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
             <div class="mb-3">
                 <label class="form-label">Nama SKPD/UPTD :</label>
                 <input type="text" name="nama_agency" value="{{ $tb_agency->nama_agency }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">Nama Pejabat/Kepala SKPD/UPTD :</label>
                 <input type="text" name="nama_pejabat" value="{{ $tb_agency->kepala_agency }}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                 <label class="form-label">NIP Pejabat/Kepala SKPD/UPTD :</label>
                 <input type="text" name="nip" value="{{ $tb_agency->nip_agency }}" class="form-control input-default" required>
             </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
