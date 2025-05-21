<form action="/opt/evaluasi/{{Crypt::encrypt($evaluasi->id_evaluasi)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
            <div class="mb-3">
                <label class="form-label">Faktor Pendukung :</label>
                <input type="text" value="{{ $evaluasi->fpendukung}}" name="fpendukung" class="form-control input-default" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Faktor Penghambat :</label>
                <input type="text" value=" {{ $evaluasi->fpenghambat }}" name="fpenghambat" class="form-control input-default" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tindak Lanjut :</label>
                <input type="text" value=" {{ $evaluasi->tindaklanjut}}" name="tindaklanjut" class="form-control input-default" required>
            </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
</form>
