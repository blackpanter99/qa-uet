@extends('web.index_master')
@section('profile_user')
    <div class="head-profile row">
        <h3>{{DB::table('users')->where('id',$id)->value('name')}}'s profile</h3>
    </div>
    <div class="body-profile row">
        <div class="col-md-8 col-sm-8 profile-left row">
            <img class="img-avatar" src="{{asset('images/web/avatar_default.png')}}" alt="">
            <ul class="list-info">
                <li id="name_profile">{{DB::table('users')->where('id',$id)->value('name')}}</li>
                <li id="role_profile">default</li>
                <li id="email_profile"><i style="margin-right: 3px" class="fas fa-envelope"></i>
                    @if(\Illuminate\Support\Facades\Auth::id() == $id)
                        {{DB::table('users')->where('id',$id)->value('email')}}
                    @else
                        Email is hidden
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-md-4 col-sm-4 profile-right">
            <ul class="list-point">
                <li id="point-1">
                    <ul id="ul-point-1">
                        <li id="question-point">Sessions</li>
                        <li id="point-question"><strong>{{DB::table('sessions')->where('id_user',$id)->count()}}</strong></li>
                    </ul>
                </li>
                <li id="point-2">
                    <ul id="ul-point-2">
                        <li id="answer-point">Surveys</li>
                        <li id="point-answer"><strong>{{DB::table('survey')->where('user_id',$id)->count()}}</strong></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer-profile row">
        <ul class="list-footer">
            <li><a href="{{route('profile_user',$id)}}">Sessions</a></li>
            <li><a href="{{route('profile.survey',$id)}}">Surveys</a></li>

        </ul>
    </div>
    <div class="list-box-question">
        @foreach($allsession as $su)
            @if(($su->id_session % 2) != 0)
                <div style="background: #fff" class="box-question row">
                    @else
                        <div  class="box-question row">
                            @endif
                            <div class="col-md-7">
                                <div class="content-box">
                                    <strong id="title-sesison"><a href="{{route("show_detail_session",$su->id_session)}}">{{$su->name_session}}</a></strong>
                                    <p>{{$su->description}}</p>
                                </div>
                                <div class="related-content row">
                                    <ul class="question-tag">
                                        <li><a href="#">{{$su->type_session}}</a></li>
                                    </ul>
                                </div>
                                <div class="user-post row">
                                    <img  id="avatar_default" src="{{asset('images/web/avatar_default.png')}}" alt="">
                                    <p id="chutoa"><a href="">{{DB::table('users')->where('id',$su->id_user)->value('name')}}</a></p>
                                    <!--  <p class="user-badge">Train </p>-->
                                    <p id="created_at">Posted on {{$su->created_at}} in <a href="#">{{$su->type_session}}</a> </p>

                                </div>
                            </div>
                            <div class="col-md-4 view-question">
                                <ul class="ul-info">
                                    <li class="session-views">
                                        <ul>
                                            <li id="views">
                                                {{$su->count_views}}
                                            </li>
                                            <li class="text-li-info">views</li>
                                        </ul>
                                    </li>
                                    <li class="session-questions">
                                        <ul>
                                            <li id="questions">{{DB::table('questions')
                                                      ->select(DB::raw('count(*) as total'))
                                                      ->where('id_session',$su->id_session)
                                                      ->value('total')}}
                                            </li>
                                            <li class="text-li-info">questions</li>
                                        </ul>
                                    </li>
                                    <li class="session-vote">
                                        <ul>
                                            <li id="votes">25</li>
                                            <li class="text-li-info">votes</li>
                                        </ul>
                                    </li>

                                </ul>

                            </div>
                            @if(\Illuminate\Support\Facades\Auth::check())
                                @if($id == \Illuminate\Support\Facades\Auth::id())
                            <div class="col-md-1">
                                <div class="delete-session"><a href="{{route('delete_session',$su->id_session)}}"><i class="fas fa-trash"></i></a></div>
                            </div>
                                @endif
                            @endif
                        </div>
                        @endforeach
                </div>
@stop

    </div>
<script>

    @if (session('delete'))
        alert({{session('delete')}});
    @endif
    @if (session('empty_survey'))
    alert({{session('empty_survey')}});
    @endif

</script>
