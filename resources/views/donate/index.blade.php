@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Donate')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        @lang('I\'m an independent developer who created this web application as a service to the community. Unfortunately, servers and some of the third-party services I use for this site come with a financial cost, so if you would like to help support the site with a monetary donation I would be eternally grateful.')
                    </p>
                    <p>
                        @lang('Donations will go toward costs associated with hosting (domain name, server droplet, server management software) and third-party services that are used for the operation of the site. If donations significantly offset these costs, I\'ll be able to upgrade the infrastructure and it\'ll also encourage me to spend more time developing and improving the site.')
                    </p>
                    <p>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick" />
                        <input type="hidden" name="hosted_button_id" value="UJWHCMUMH4ZWQ" />
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                        <img alt="" border="0" src="https://www.paypal.com/en_CA/i/scr/pixel.gif" width="1" height="1" />
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
