<form action="/opt/rtargetapbd/{{Crypt::encrypt($data->id_rtarget)}}/update"  method="POST" enctype="multipart/form-data">
         @csrf
            <div class="mb-3">
                <label class="form-label">Uraian Target :</label>
                <input type="text" placeholder="Masukkan Uraian" name="uraian" value="{{ $data->uraian_rtarget}}" class="form-control input-default" required>
             </div>
             <div class="mb-3">
                <label class="form-label">Pagu Target (Rp) :</label>
                <input type="text" placeholder="0" name="pagutarget" id="edit1pagu" value="{{ $data->pagu_rtarget}}" class="form-control input-default pagu" required>
             </div>
             <div class="mb-3">
                <label class="form-label">Jenis Retribusi :</label>
                <select class="input-default  form-control" name="jenis" id="SelectJre">
                <option value="">Pilih Jenis Retribusi</option>
                @foreach ($jenis as $d)
                <option {{ $data->id_jr == $d->id_jr ? 'selected' : '' }}
                value="{{ $d->id_jr }}">{{$d->kode_jr }} - {{$d->nama_jr }} </option>
                @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Sub Retribusi :</label>
                <select class="input-default  form-control" name="sub" id="SelectSre">
                <option value="">Pilih Sub Retribusi</option>
                @foreach ($sub as $d)
                <option {{ $data->id_sr == $d->id_sr ? 'selected' : '' }}
                value="{{ $d->id_sr }}">{{$d->kode_sr }} - {{$d->nama_sr }} </option>
                @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Objek Retribusi :</label>
                <select class="input-default  form-control" name="objek" id="ojke">
                <option value="">Pilih Objek Retribusi</option>
                @foreach ($objek as $d)
                <option {{ $data->id_ojk == $d->id_ojk ? 'selected' : '' }}
                value="{{ $d->id_ojk }}">{{$d->kode_ojk }} - {{$d->nama_ojk }} </option>
                @endforeach
                </select>
            </div>
        </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Batal</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
         </form>
