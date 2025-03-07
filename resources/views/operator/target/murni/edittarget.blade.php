<form action="/opt/targetapbd/{{Crypt::encrypt($target->id_target)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
             <div class="mb-3">
                <label class="form-label">Pagu Target (Rp) :</label>
                <input type="text" placeholder="0" name="pagutarget" id="edit1pagu" value="{{$target->pagu_target}}" class="form-control input-default pagu" required>
             </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
