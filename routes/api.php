<?php

use Illuminate\Http\Request;
use  App\Http\Middleware\CheckToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('Admin')->group(function () {
   Route::post('/adminlogin','AdminController@login');
   Route::post('/adminforgotpassword','AdminController@forgotpassword');
   Route::post('/adminrestorepassword','AdminController@restorepassword');

});

Route::namespace('Admin')->middleware('token')->group(function () {
    Route::post('/createadmin','AdminController@create');
    Route::post('/editadmin','AdminController@update');
    Route::get('/adminlist','AdminController@list');
    Route::get('/admin/list','AdminController@index');
    Route::delete('/deleteadmin','AdminController@destroy');
    Route::get('/showadmin','AdminController@show');
    Route::get('/admininfo','AdminController@show');
    Route::post('/checkadminsession','AdminController@checksession');
    Route::post('/admineditpassword','AdminController@editpassword');
    /*课程演讲者*/
    Route::get('/speaker/list','SpeakerController@index');
    Route::get('/speakerlist','SpeakerController@list');
    Route::post('/createspeaker','SpeakerController@create');
    Route::post('/editspeaker','SpeakerController@update');
    Route::post('/deletespeaker','SpeakerController@destroy');
    Route::post('/speakerinfo','SpeakerController@show');
    Route::post('/viewspeakercover','SpeakerController@show');
    Route::post('/editspeakercover','SpeakerController@edit_speaker_cover');

    /*课程路由*/
    Route::get('/course/list','CourseController@index');
    Route::get('/courselist','CourseController@list');
    Route::post('/createcourse','CourseController@create');
    Route::post('/editcourse','CourseController@update');
    Route::post('/deletecourse','CourseController@destroy');
    Route::get('/courseinfo','CourseController@show');
    Route::get('coursecatelog','CourseController@course_catelog');


    /*课程章节路由*/
    Route::post('/section/list','SectionController@index');
    Route::post('/sectionlist','SectionController@list');
    Route::post('/createsection','SectionController@create');
    Route::post('/editsection','SectionController@update');
    Route::post('/deletesection','SectionController@destroy');
    Route::post('/sectioninfo','SectionController@show');
    /*课程视频路由*/
    Route::post('/video/list','VideoController@index');
    Route::post('/videolist','VideoController@list');
    Route::post('/createvideo','VideoController@create');
    Route::post('/editvideo','VideoController@update');
    Route::post('/deletevideo','VideoController@destroy');
    Route::post('/videoinfo','VideoController@show');
    Route::post('lockvideo','VideoController@lockvideo');

    /*课程学习*/
    Route::post('/courselearning/list','CourseLearningController@index');
    Route::post('/courselearninglist','CourseLearningController@list');
    Route::post('/createcourselearning','CourseLearningController@create');
    Route::post('/editcourselearning','CourseLearningController@update');
    Route::post('/deletecourselearning','CourseLearningController@destroy');
    Route::post('/courselearninginfo','CourseLearningController@show');

    /*课程小测试*/
    Route::post('/quiz/list','QuizController@index');
    Route::post('/quizlist','QuizController@list');
    Route::post('/createquiz','QuizController@create');
    Route::post('/editquiz','QuizController@update');
    Route::post('/deletequiz','QuizController@destroy');
    Route::post('/quizinfo','QuizController@show');

    /*课程答案小测试*/
    Route::post('/quizanswer/list','QuizAnswerController@index');
    Route::post('/quizanswerlist','QuizAnswerController@list');
    Route::post('/createanswer','QuizAnswerController@create');
    Route::post('/editquizanswer','QuizAnswerController@update');
    Route::post('/deleteanswer','QuizAnswerController@destroy');
    Route::post('/quizanswerinfo','QuizAnswerController@show');
    Route::post('/setanswer','QuizAnswerController@setanswer');

    /*目录与视频*/
    Route::get('/sectionvideo/list','SectionVideoController@index');
    Route::get('/sectionvideolist', 'CourseSectionController@listCourseSection');
    Route::post('/createsectionvideo','SectionVideoController@create');
    Route::post('/editsectionvideo','SectionVideoController@update');
    Route::get('/deletesectionvideo','SectionVideoController@destroy');
    Route::get('/sectionvideoinfo','SectionVideoController@show');
    /*课程与目录*/
    Route::post('/coursesection/list','CourseSectionController@index');
    Route::post('/coursesectionlist','CourseSectionController@list');
    Route::post('/createcoursesection','CourseSectionController@create');
    Route::post('/editcoursesection','CourseSectionController@update');
    Route::post('/deletecoursesection','CourseSectionController@destroy');
    Route::post('/coursesectioninfo','CourseSectionController@show');

    /*课程与经验者*/
    Route::get('/speakcourse/list','SpeakCourseController@index');
    Route::get('/speakcourselist','SpeakCourseController@list');
    Route::post('/createspeakcourse','SpeakCourseController@create');
    Route::post('/editspeakcourse','SpeakCourseController@update');
    Route::post('/deletespeakcourse','SpeakCourseController@destroy');
    Route::post('/speakcourseinfo','SpeakCourseController@show');
    Route::post('/speakcourse','SpeakCourseController@show_by_spid');

    /*用户级别*/
    Route::post('/userlevel/list','UserLevelController@index');
    Route::post('/userlevellist','UserLevelController@list');
    Route::post('/createuserlevel','UserLevelController@create');
    Route::post('/edituserlevel','UserLevelController@update');
    Route::post('/deleteuserlevel','UserLevelController@destroy');
    Route::post('/userlevelinfo','UserLevelController@show');
    /*用户积分*/
    Route::post('/userpoint/list','UserpointController@index');
    Route::post('/userpointlist','UserpointController@list');
    Route::post('/createuserpoint','UserpointController@create');
    Route::post('/edituserpoint','UserpointController@update');
    Route::post('/deleteuserpoint','UserpointController@destroy');
    Route::post('/userpointinfo','UserpointController@show');
    Route::post('/multipleuseraddpoint','UserpointController@update_user_point');
    Route::post('/addpoint','UserpointController@update_point');
    /*公共接口*/
    Route::get('/ses','ToolsController@sent_ses');

    /*邮件发送*/
    Route::post('/mail/list','MailboxController@index');
    Route::post('/maillist','MailboxController@list');
    Route::post('/createmail','MailboxController@create');
    Route::post('/editmail','MailboxController@update');
    Route::post('/deletemailbox','MailboxController@destroy');
    Route::post('/mailboxinfo','MailboxController@show');
    Route::post('/sentmail','MailboxController@sentmail');
    Route::post('/savedraft','MailboxController@save_draft');
    /*动态信息*/
    Route::post('/newsfeed/list','NewsFeedController@index');
    Route::post('/newsfeedlist','NewsFeedController@list');
    Route::post('/createnewsfeed','NewsFeedController@create');
    Route::post('/editnewsfeed','NewsFeedController@update');
    Route::post('/deletenewsfeed','NewsFeedController@destroy');
    Route::get('/newsfeedinfo','NewsFeedController@show');
    Route::post('/sharenewsfeed','NewsFeedController@share_news_feed');
    /*系列路由*/
    Route::post('/series/list','NewSeriesController@index');
    Route::post('/serieslist','NewSeriesController@list');
    Route::post('/createseries','NewSeriesController@create');
    Route::post('/editseries','NewSeriesController@update');
    Route::post('/deletenewseries','NewSeriesController@destroy');
    Route::post('/newseriesinfo','NewSeriesController@show');

    Route::get('/series_chapter_list','SeriesChapterController@get_series_chapter');
    /*章节路由*/
    Route::post('/chapter/list','NewChapterController@index');
    Route::post('/chapterlist','NewChapterController@list');
    Route::post('/createchapter','NewChapterController@create');
    Route::post('/editchapter','NewChapterController@update');
    Route::post('/deletechapter','NewChapterController@destroy');
    Route::post('/newchapterinfo','NewChapterController@show');
    /*章节与系列*/
    Route::post('/serieschapter/list','SeriesChapterController@index');
    Route::post('/serieschapterlist','SeriesChapterController@list');
    Route::post('/createserieschapter','SeriesChapterController@create');
    Route::post('/editserieschapter','SeriesChapterController@update');
    Route::post('/deleteserieschapter','SeriesChapterController@destroy');
    Route::get('/serieschapterinfo','SeriesChapterController@show');
    /*推销码*/
    Route::post('/promocode/list','PromocodeController@index');
    Route::post('/promocodelist','PromocodeController@list');
    Route::post('/createpromocode','PromocodeController@create');
    Route::post('/editpromocode','PromocodeController@update');
    Route::post('/deletepromocode','PromocodeController@destroy');
    Route::post('/promocodeinfo','PromocodeController@show');
    /*用户信息*/
    Route::get('/user/list','UserController@index');
    Route::get('/userlist','UserController@list');
    Route::post('/createuser','UserController@create');
    Route::post('/edituser','UserController@update');
    Route::post('/deleteuser','UserController@destroy');
    Route::get('/userinfo','UserController@show');
    Route::get('/referralrecord/list','UserController@referralrecord_page');
    Route::get('/referralrecord','UserController@referralrecord');

    Route::get('/purchased-courses','UserController@purchased_courses');
    Route::get('/purchased-courses/list','UserController@purchased_courses_page');
    /*用户课程*/
    Route::post('/usercourse/list','UserCourseController@index');
    Route::post('/usercourselist','UserCourseController@list');
    Route::post('/createusercourse','UserCourseController@create');
    Route::post('/editusercourse','UserCourseController@update');
    Route::post('/deleteusercourse','UserCourseController@destroy');
    Route::post('/usercourseinfo','UserCourseController@show');
    /*用户交易*/
    Route::get('/transaction/list','TransactionController@index');
    Route::get('/transactionlist','TransactionController@list');
    Route::post('/createtransaction','TransactionController@create');
    Route::post('/edittransaction','TransactionController@update');
    Route::post('/deletetransaction','TransactionController@destroy');
    Route::post('/transactioninfo','TransactionController@show');

    /*用户锁定*/
    Route::get('/userunlock/list','UserUnlockController@index');
    Route::get('/userunlocklist','UserUnlockController@list');
    Route::post('/createuserunlock','UserUnlockController@create');
    Route::post('/edituserunlock','UserUnlockController@update');
    Route::get('/deleteuserunlock','UserUnlockController@destroy');
    Route::post('/userunlockinfo','UserUnlockController@show');
});
