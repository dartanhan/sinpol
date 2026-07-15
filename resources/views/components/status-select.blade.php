@props(['status' => '1'])

<div class="col-md-6 text-start">
    <label for="status" class="form-label fw-bold">Status de Visualização</label>
    <select name="status" id="status" class="form-select" required>
        <option value="1" {{ old('status', $status) == '1' ? 'selected' : '' }}>PUBLICADO / ATIVO</option>
        <option value="0" {{ old('status', $status) == '0' ? 'selected' : '' }}>RASCUNHO / INATIVO</option>
    </select>
</div>
