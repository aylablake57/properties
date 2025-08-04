<div id="callModal-{{ $user->id }}" class="modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="text-center modal-title">Contact Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h6 class="text-capitalize">{{ $user->name }}</h6>
                    <p>{{ $user->user_type->name }}</p>
                    <table class="table my-3 table-borderless text-start">
                        <tr class="border-bottom">
                            <td class="pt-4"><i class="fa-solid fa-mobile-screen"></i></td>
                            <td>
                                <span class="fs-12">Mobile</span>
                                <p id="mobileNumber">
                                    @if($user->phone)
                                        {{ CellPhoneNumber($user->phone) }}
                                    @else
                                        Not Provided
                                    @endif
                                </p>
                            </td>
                            @if ($user->phone)
                                <td class="pt-4 text-accent">
                                    <a href="javascript:;" class="text-decoration-none text-accent" onclick="copyText('mobileNumber', 'copyIcon-mobile')">
                                        <i id="copyIcon-mobile" class="fa-regular fa-copy me-2"></i>Copy
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @isset($user->landline)
                        <tr class="border-bottom">
                            <td class="pt-4"><i class="fa-solid fa-phone"></i></td>
                            <td>
                                <span class="fs-12">Landline</span>
                                <p id="landline">
                                    @if($user->landline)
                                        {{ $user->landline }}
                                    @else
                                        Not Provided
                                    @endif
                                </p>
                            </td>
                            @if ($user->landline)
                                <td class="pt-4 text-accent">
                                    <a href="javascript:;" class="text-decoration-none text-accent" onclick="copyText('landline', 'copyIcon-landline')">
                                        <i id="copyIcon-landline" class="fa-regular fa-copy me-2"></i>Copy
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
