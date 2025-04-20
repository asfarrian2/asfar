         <form action="/opt/realisasi/store"  method="POST" enctype="multipart/form-data">
         @csrf
             <div class="mb-3">
                 <label class="form-label">Objek Retribusi :</label>
                 <input type="hidden" name="rtarget" value="{{ $id_rtarget }}" class="form-control input-default" required>
                 <input type="hidden" name="bulan" value="{{ $id_bulan }}" class="form-control input-default" required>
                 <input type="text" name="objek" value="{{ $data->uraian_rtarget }}" class="form-control input-default" readonly>
             </div>
             <div class="mb-3">
                 <label class="form-label">Realisasi :</label>
                 <input type="text" name="realisasi" placeholder="Rp 0" class="form-control input-default pagu" required>
             </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
