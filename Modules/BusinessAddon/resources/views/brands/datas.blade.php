@foreach($brands as $brand)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="w-60 checkbox table-data">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $brand->id }}">
        </td>
        <td class="table-data">{{ ($brands->currentPage() - 1) * $brands->perPage() + $loop->iteration }}</td>
        <td class="table-data">
            <img src="{{ asset($brand->icon ?? 'assets/images/logo/no-image.jpg') }}" alt="Img" class="table-img">
        </td>

        <td class="text-start table-data">{{ $brand->brandName }}</td>
        <td class="text-start table-data">{{ Str::limit($brand->description, 20, '...') }}</td>
        <td class=" table-data">
            <label class="switch">
                <input type="checkbox" {{ $brand->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.brands.status', $brand->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td class="print-d-none table-data">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#brand-edit-modal" data-bs-toggle="modal" class="brand-edit-btn"
                        data-url="{{ route('business.brands.update', $brand->id) }}"
                        data-brands-name="{{ $brand->brandName }}"
                        data-brands-icon="{{ asset($brand->icon ?? 'assets/images/icons/upload-icon.svg') }}"
                        data-brands-description="{{ $brand->description }}"><i class="fal fa-pencil-alt"></i>{{__('Edit')}}</a>
                    </li>
                    <li>
                        <a href="{{ route('business.brands.destroy', $brand->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
