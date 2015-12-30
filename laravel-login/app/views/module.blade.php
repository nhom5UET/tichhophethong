

@extends("main")

@section('title')
    Welcome
@endsection

@section('content')
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script language="javascript">
//        function load_ajax(){
//            $.ajax({
//                url: 'http://localhost/laravel-login/public/Chikitsa/index.php/patient/insert/',
//                type: 'GET',
//                dataType: 'text',
//                data: {
//                },
//                success: function(result){
//                    $('#result').html(result);
//                }
//            });
//        }
//        function load_ajax1(){
//            $.ajax({
//                url: 'http://localhost/laravel-login/public/gco_smile/index.php',
//                type: 'GET',
//                dataType: 'text',
//                data: {
//                },
//                success: function(iframe){
//                    $('#iframe').html(iframe);
//                }
//            });
//        }
        function setURL(url){
            document.getElementById('iframe').src = url;
        }

    </script>

    <table>
        <tr>
            <td width="100px" align="left">
                </form>
                <form method="post" action="gco_smile/index.php" id="form-gco_smile">
                    <h2>Module</h2>
                    </br>
                    <input type="button" width="10px" class="btn btn-lg btn-primary btn-block" name="clickme1" id="clickme1"
                           {{--onclick="setURL('http://192.168.13.128/hvol/index.php/hospice/super/locations/locDir')" value="Tình nguyện viên"/>--}}
                           onclick="setURL('http://localhost/hvol/index.php/hospice/super/locations/locDir')" value="Tình nguyện viên"/>
                </form>
                <form>
                    </br>
                    <input type="button" width="10px" class="btn btn-lg btn-primary btn-block" name="clickme1" id="clickme1"
                           {{--onclick="setURL('http://192.168.13.128/Chikitsa/index.php/patient/insert/')" value="Thêm bệnh nhân"/>--}}
                           onclick="setURL('http://localhost/Chikitsa/index.php/patient/insert/')" value="Thêm bệnh nhân"/>
                </form>
                <form>
                    </br>
                    <input type="button" class="btn btn-lg btn-primary btn-block" name="clickme2" id="clickme2"
                           {{--onclick="setURL('http://192.168.13.128/laravel-login/public/gco_smile/index.php')" value="Nha khoa"/>--}}
                           onclick="setURL('http://localhost/gco_smile/index.php')" value="Nha khoa"/>
                </form>
                <form method="post" action="logout">
                    </br>
                    <button class="btn btn-lg btn-primary btn-block" name="form-logout" value="1">Logout</button>
                </form>
            </td>
            <td width="90%">
                <div id="result">
                </div>
                <iframe id="iframe" width="1000px" height="600px" frameborder="0"/>

            </td>
        </tr>
    </table>
@endsection
