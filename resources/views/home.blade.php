@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>




    <div class="row">

      <div class="msg">

      </div>



        <div class="col-md-6">
        <form action="{{url('addrecipe')}}"  class="myform" method="POST"> 
               @csrf

              <div class="mb-3">
                <label for="TextInput" class="form-label">Recipe name</label>
                <input type="text" id="TextInput" class="form-control" name="recipe_name" placeholder=" input">
              </div>
              <div class="mb-3">
                <label for="Select" class="form-label"> Category</label>
                <select id="Select" class="form-select"  name="category_id">
                    @foreach ($cat as $item)
                    <option value="{{$item->id}}"> {{$item->name}}</option>
                    @endforeach
                

                </select>
              </div>
              <div class="mb-3">
                <label for="TextInput" class="form-label">Range from</label>
                <input type="number" id="TextInput" class="form-control"   name="range_from" placeholder=" input">
              </div>
   
              <div class="mb-3">
                <label for="TextInput" class="form-label" >Range to</label>
                <input type="number" id="TextInput" class="form-control" name="range_to" placeholder=" input">
              </div>

              <input type="hidden" class="baseurl" baseurl="{{url('list')}}">
              <button type="submit" class="btn btn-primary">Submit</button>
            </fieldset>
          </form>
        </div>

      
        <button class="btn btn-primary export mt-4" data_url="{{url('export')}}"> Export CSV</button>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Recipe name</th>
                <th scope="col">Category</th>
                <th scope="col">Range from</th>
                <th scope="col">Range to</th>
              </tr>
            </thead>
            <tbody class="listing">
              
             
            </tbody>
          </table>
    </div>
</div>
@endsection
