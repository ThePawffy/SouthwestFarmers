@foreach($categories as $category)
    <tr class="{{ $loop->iteration % 2 == 0 ? 'even-row' : 'odd-row' }}">
        <td class="w-60 checkbox table-data">
            <input type="checkbox" name="ids[]" class="delete-checkbox-item  multi-delete" value="{{ $category->id }}">
        </td>
            <td class="table-data">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
        <td class="table-data">
            <img src="{{ asset($category->icon ?? 'assets/images/logo/no-image.jpg') }}" alt="Img" class="table-img">
        </td>

        <td class="text-start table-data">{{ $category->categoryName }}</td>
        <td class="text-center table-data">
            <label class="switch">
                <input type="checkbox" {{ $category->status == 1 ? 'checked' : '' }} class="status" data-url="{{ route('business.categories.status', $category->id) }}">
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
                        <a href="#category-edit-modal" class="category-edit-btn" data-bs-toggle="modal"
                           data-url="{{ route('business.categories.update', $category->id) }}"
                           data-category-name="{{ $category->categoryName }}"
                           data-category-icon="{{ asset($category->icon ?? 'assets/images/icons/upload-icon.svg') }}"
                           data-category-variationcapacity="{{ $category->variationCapacity }}"
                           data-category-variationcolor="{{ $category->variationColor }}"
                           data-category-variationsize="{{ $category->variationSize }}"
                           data-category-variationtype="{{ $category->variationType }}"
                           data-category-variationweight="{{ $category->variationWeight }}">
                            <i class="fal fa-pencil-alt"></i>{{__('Edit')}}
                        </a>

                    </li>
                    <li>
                        <a href="{{ route('business.categories.destroy', $category->id) }}" class="confirm-action" data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
