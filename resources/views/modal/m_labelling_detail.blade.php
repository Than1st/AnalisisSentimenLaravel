@foreach ($teksBersih as $teks)
<div class="modal fade" id="modaldetail{{ $teks->id_teks_bersih }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div><b>User:</b></div>
                <div>{{ $teks->user }}</div>
                <div><b>Real Text:</b></div>
                <div>{{ $teks->real_text }}</div>
                <div><b>Clean Text:</b></div>
                <div>{{ $teks->clean_text }}</div>
                <div><b>Label Sentiment:</b></div>
                <div>
                    @if($teks->label_sentimen == "positif")
                    <td><span class="badge bg-success text-white" style="font-size: 18px;">Positif</span></td>
                    @elseif($teks->label_sentimen == "negatif")
                    <td><span class="badge bg-danger text-white">Negatif</span></td>
                    @else
                    <td><span class="badge bg-secondary text-white">Belum diberi Label</span></td>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach