<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Contact;
use App\Repos\ApartmentsRepo;
use App\Http\Requests;

class ApartmentsController extends BaseController
{
    /**
     * @param \App\Repos\ApartmentsRepo $repo
     */
    public function __construct(ApartmentsRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = request('filters', []);

        $items = $this->repo->findAll($filters, []);

        return view('apartments.index', compact('items'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function item($item_id = null)
    {
      if(strlen($item_id) == 1){
        $item = $this->bringOrNew($this->repo, $item_id);
      }elseif(strlen($item_id) > 1){
        $item = Apartment::where('apartment_token','=',$item_id)->first();

      }else{
        $item = $this->bringOrNew($this->repo, $item_id);
      }
        //dd($item);

        return view('apartments.edit', compact('item'));
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
     public function store($item_id = null)
     {
         if(strlen($item_id) == 1){
           $item = $this->bringOrNew($this->repo, $item_id);
         }elseif(strlen($item_id) > 1){
           $item = Apartment::where('apartment_token','=',$item_id)->first();

         }else{
           $item = $this->bringOrNew($this->repo, $item_id);
         }

         $data = request()->all();
         $contact=Contact::find($data['contact_id']);

         $item = $this->repo->update($item, $data);
         //dd($item->id);
         \Mail::send('emails.email', ['data' => $data,'contact'=>$contact,'item'=>$item], function ($m) use ($data,$contact) {
              $m->from('emadelmogy619@gmail.com', 'Your Application');

              $m->to($contact->email, $contact->name)->subject('Your Reminder!');
          });

         return redirect('apartments')->with('success', true);
     }

     public function item_token($item_id=null,$token){
       $contact=Contact::where('contact_token',$token)->first();
       $item = Apartment::where('id','=',$item_id)->where('contact_id','=',$contact->id)->first();
       return view('apartments.edit', compact('item'));
     }
}
