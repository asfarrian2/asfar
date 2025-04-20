         <form action="/opt/realisasi/{{Crypt::encrypt($data->id_realisasi)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
             <div class="mb-3">
                 <label class="form-label">Objek Retribusi :</label>
                 <input type="text" name="objek" value="{{ $data->uraian_rtarget }}" class="form-control input-default" readonly>
             </div>
             <div class="mb-3">
                 <label class="form-label">Realisasi :</label>
                 <input type="text" name="realisasi" value="{{ $data->pagu_realisasi }}" class="form-control input-default pagu" required>
             </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
