@extends('layout.layout')
@section('title','Create Article')
@section('pageTitle','Article')
@section('mainTitle','Admin')
@section('body')


    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">create Article</h5>

                                <!-- Floating Labels Form -->
                                <form class="row g-3" action="/admin/ManageArticle" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="slug" class="form-control" id="floatingEmail"
                                                   placeholder="slug..." required>
                                            <label for="floatingEmail">slug</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" name="title" class="form-control" id="floatingPassword"
                                                   placeholder="title..." required>
                                            <label for="floatingPassword">title</label>
                                        </div>
                                    </div>

                                    <x-ArticleCategories/>


                                    <div class="col-12">
                                        <div class="form-floating">
                                            <!-- Quill Editor Default -->
                                            <textarea class="col-12" id="content" name="content" required>
                                                <p>put article here...</p>
                                            </textarea>

                                            <!-- End Quill Editor Default -->
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <!-- Quill Editor Default -->
                                            <input type="file" name="img" required>
                                            <!-- End Quill Editor Default -->
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </form>
                                <!-- End floating Labels Form -->

                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

            @include('layout._rightNav')
        </div>
    </section>

@endsection
