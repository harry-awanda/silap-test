<table class="table table-responsive table-hover datatable">
  <thead>
    <tr>
      <th>Nama Siswa</th>
      <th>Sakit</th>
      <th>Izin</th>
      <th>Alpa</th>
    </tr>
  </thead>
  <tbody>
    @foreach($siswa as $s)
    <tr>
      <td>{{ $s->nama_lengkap }}</td>
      <td>
        <input type="radio" name="attendance[{{ $s->id }}][status]" value="sakit"
        {{ isset($attendances[$s->id]) && $attendances[$s->id]->status == 'sakit' ? 'checked' : '' }}>
      </td>
      <td>
        <input type="radio" name="attendance[{{ $s->id }}][status]" value="izin"
        {{ isset($attendances[$s->id]) && $attendances[$s->id]->status == 'izin' ? 'checked' : '' }}>
      </td>
      <td>
        <input type="radio" name="attendance[{{ $s->id }}][status]" value="alpa"
        {{ isset($attendances[$s->id]) && $attendances[$s->id]->status == 'alpa' ? 'checked' : '' }}>
      </td>
      <input type="hidden" name="attendance[{{ $s->id }}][siswa_id]" value="{{ $s->id }}">
    </tr>
    @endforeach
  </tbody>
</table> 