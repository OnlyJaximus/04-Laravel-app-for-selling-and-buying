<button class="btn btn-success form-control m-2">
    Deposit:  {{ (Auth::user()->deposit)? Auth::user()->deposit : 0}} rsd
</button>

{{-- <a href="{{ route('home')}}" class="btn btn-secondary form-control m-2">All ads</a> --}}
<a href="{{ route('home')}}" class="btn btn-secondary form-control m-2">Svi vasi oglasi</a>
<a href="{{ route('home.addDeposit')}}" class="btn btn-secondary form-control m-2">Dodaj deposit</a>
<a href="{{ route('home.showMessage')}}" class="btn btn-secondary form-control m-2">Poruke
<span class="badge rounded-pill bg-warning text-dark">{{Auth::user()->messages->count()  }}</span></a>
<a href="{{ route('home.showAdForm') }}" class="btn btn-primary form-control m-2">Postavi novi oglas</a>