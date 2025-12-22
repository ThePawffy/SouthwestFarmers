@foreach ($tutorials as $tutorial)
    <tr>
        <td class="w-60 checkbox table-data">
            <label class="table-custom-checkbox">
                <input type="checkbox" name="ids[]" class="table-hidden-checkbox checkbox-item"
                    value="{{ $tutorial->id }}" data-url="{{ route('admin.tutorials.delete-all') }}">
                <span class="table-custom-checkmark custom-checkmark"></span>
            </label>
        </td>
        <td>{{ $tutorials->firstItem() + $loop->index }}</td>
        <td>
            <img class="table-img" src="{{ asset($tutorial->thumbnail ?? 'assets/images/icons/no-img.svg') }}"
                alt="">
        </td>
        <td>{{ $tutorial->title ?? '' }}</td>
        <td>
            <a href="{{ $tutorial->url }}" target="_blank">
                {{ $tutorial->url }}
            </a>
        </td>
        <td>
            <label class="switch">
                <input type="checkbox" {{ $tutorial->status == 1 ? 'checked' : '' }} class="status"
                    data-url="{{ route('admin.tutorials.status', $tutorial->id) }}">
                <span class="slider round"></span>
            </label>
        </td>
        <td class="print-d-none">
            <div class="dropdown table-action">
                <button type="button" data-bs-toggle="dropdown">
                    <i class="far fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#tutorial-edit-modal" data-bs-toggle="modal" class="tutorial-edit-btn"
                            data-url="{{ route('admin.tutorials.update', $tutorial->id) }}"
                            data-title="{{ $tutorial->title ?? '' }}" data-tutorial-url="{{ $tutorial->url ?? '' }}"
                            data-thumbnail="{{ asset($tutorial->thumbnail ?? 'assets/images/icons/no-img.svg') }}"><i
                                class="fal fa-pencil-alt"></i>{{ __('Edit') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.tutorials.destroy', $tutorial->id) }}" class="confirm-action"
                            data-method="DELETE">
                            <i class="fal fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
@endforeach
