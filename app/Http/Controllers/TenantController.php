<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.tenant');
    }

    /**
     * Store a newly created resource in storage.
     * @var https://laravel-tenancy.com/docs/hyn/5.3/creating-tenants
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant' => 'required|string|min:2',
            'email' => 'required|email',
        ]);

        // Create Website
        // Instantiates DATABASE for tenant, assigns a UUID
        // The UUID is used for the database username and database name
        $website = new \Hyn\Tenancy\Models\Website;
        app(\Hyn\Tenancy\Contracts\Repositories\WebsiteRepository::class)->create($website);

        // Create And Connect Hostname
        $hostname = new \Hyn\Tenancy\Models\Hostname;
        $hostname->fqdn = $request['tenant'] . '.' . request()->getHost();
        $hostname = app(\Hyn\Tenancy\Contracts\Repositories\HostnameRepository::class)->create($hostname);
        app(\Hyn\Tenancy\Contracts\Repositories\HostnameRepository::class)->attach($hostname, $website);

        // Switch To New Tenant
        $tenancy = app(\Hyn\Tenancy\Environment::class);
        $tenancy->hostname($hostname);
        $tenancy->hostname(); // resolves $hostname as currently active hostname
        $tenancy->tenant($website); // switches the tenant and reconfigures the app
//        $tenancy->website(); // resolves $website
//        $tenancy->tenant(); // resolves $website
//        $tenancy->identifyHostname(); // resets resolving $hostname by using the Request

        $target = $request->getScheme() . '://' . $hostname->fqdn . ':' . $request->getPort();
        // todo: Class 'Flash' not found! WTF!
        // \Flash::success('Registered! ' . "<a href='$target'>Redirect</a> to new organization.");

        $administrator = User::find(1);
        $administrator->email = $request->email;
        $administrator->save();

        $token = Password::broker()->createToken($administrator);
        $passwordResetUrl = $request->getScheme() . "://{$hostname->fqdn}:" . $_SERVER['SERVER_PORT'] . "/password/reset/{$token}";

        // \Mail::send(new \App\Mail\AdministratorInvite($passwordResetUrl, $request->email));

        return redirect(str_slug('init tenant'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
