<div class="form-group">
  <label for="title">リスト名</label>
  <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $title) }}" />
</div>
<div class="text-right">
  <input type="submit" class="btn btn-primary" value="{{ $submitBtn }}">
</div>