@if(count($clients->where('types', 'clients')) > 0)
    <section class="brand-two py-5">
        <div class="container">
            <div class="row">
                @foreach($clients->where('types', 'clients') as $client)
                    <div class="item col-sm-12 col-md-6 col-lg-3">
                        <div class="brand-two__single">
                            <div class="brand-two__img filter-brightness">
                                <img src="{{WebsiteHelper::getImage('clients',$client->image) }}" alt="{{ $client->alt_image }}" />
                                <h5>{{$client->name}}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
