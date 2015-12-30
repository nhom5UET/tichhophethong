@extends("main")

@section('title')
    Register
@endsection

@section('content')
    <form method="post" action="{{Asset('register')}}" id="form-register">
        <h2>Register</h2>
        <input type="text" name="username" id="username" placeholder="Username" class="form-control"/>
        <input type="password" name="password" id="password" placeholder="Password" class="form-control"/>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-password" class="form-control"/>
        <input type="email" name="email" id="email" placeholder="Email" class="form-control"/>
        <button class="btn btn-lg btn-primary btn-block">Register</button>
    </form>
    <script type="text/javascript">
    $("#form-register").validate({
        rules:{
            username:{
                required:true,
                minlength:3
            },
            password:{
                required:true,
                minlength:4
            },
            password_confirmation:{
                equalTo:"#password"
            },
            email:{
                required:true,
                email:true,
            }
        },
//        messages:{
//            username:{
//                required:"Vui lòng nh?p username",
//                minlength:"Ph?i nh?p ít nh?t 3 kí t?"
//            },
//            password:{
//                required:"Vui lòng nh?p m?t kh?u",
//                minlength:"M?t kh?u ph?i l?n h?n 6 ký t?"
//            },
//            password_confirmation:{
//                equalTo:"M?t kh?u không ?úng"
//            },
//            email:{
//                required:"Vui lòng nh?p Email",
//                email:"??nh d?ng email không ?úng",
//            }
//        }
    })
    </script>
@endsection