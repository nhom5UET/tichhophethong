@extends("main")

@section('title')
    Patients
@endsection

@section('content')
    <form method="post" action="{{Asset('patient')}}" id="form-patient">
        <h2>Patient</h2>
        {{--<input type="text" name="id_patient" id="id_patient" placeholder="ID" class="form-control"/>--}}
        {{--<input type="text" name="firstname" id="firstname" placeholder="Firstname" class="form-control"/>--}}
        {{--<input type="text" name="middelname" id="middelname" placeholder="Middelname" class="form-control"/>--}}
        {{--<input type="text" name="lastname" id="lastname" placeholder="Lastname" class="form-control"/>--}}
        {{--<input type="text" name="phonenumber" id="phonenumber" placeholder="Phonenumber" class="form-control"/>--}}
        {{--<input type="text" name="displayname" id="displayname" placeholder="Displayname" class="form-control"/>--}}
        {{--<input type="email" name="email" id="email" placeholder="Email" class="form-control"/>--}}
        {{--<input type="text" name="address" id="address" placeholder="Address" class="form-control"/>--}}
        {{--<input type="text" name="city" id="city" placeholder="City" class="form-control"/>--}}
        {{--<input type="text" name="state" id="state" placeholder="State" class="form-control"/>--}}
        {{--<input type="text" name="postalcode" id="postalcode" placeholder="Postalcode" class="form-control"/>--}}
        {{--<input type="text" name="country" id="country" placeholder="Country" class="form-control"/>--}}
        {{--<button class="btn btn-lg btn-primary btn-block">Submit</button>--}}
        <input type="text" name="contact_id" id="contact_id" placeholder="ID" class="form-control"/>
        <input type="text" name="first_name" id="first_name" placeholder="Firstname" class="form-control"/>
        <input type="text" name="middle_name" id="middle_name" placeholder="Middelname" class="form-control"/>
        <input type="text" name="last_name" id="last_name" placeholder="Lastname" class="form-control"/>
        <input type="text" name="phone_number" id="phone_number" placeholder="Phonenumber" class="form-control"/>
        <input type="text" name="display_name" id="display_name" placeholder="Displayname" class="form-control"/>
        <input type="email" name="email" id="email" placeholder="Email" class="form-control"/>
        <input type="text" name="address_line_1" id="address_line_1" placeholder="Address" class="form-control"/>
        <input type="text" name="city" id="city" placeholder="City" class="form-control"/>
        <input type="text" name="state" id="state" placeholder="State" class="form-control"/>
        <input type="text" name="postal_code" id="postal_code" placeholder="Postalcode" class="form-control"/>
        <input type="text" name="country" id="country" placeholder="Country" class="form-control"/>
        <input type="text" name="job" id="job" placeholder="Job" class="form-control"/>
        <button class="btn btn-lg btn-primary btn-block">Submit</button>
    </form>
    <script type="text/javascript">
        $("#form-patient").validate({
            rules:{
                email:{
                    required:true,
                    email:true,
                }
            },
        })
    </script>
@endsection