@extends('Page/Admin/App')

@section('title', $title)

@section('style')
    @parent
    <style>
        * {
            /*border: solid 1px;*/
        }

        #MerchandiseSingleForm {
            width: 800px;
            padding-left: 20px;
            padding-top: 10px;
        }

        #MerchandiseSingleForm .submitBtn{
            margin-top: 15px;
            margin-bottom: 20px;
        }

        #MerchandiseSingleForm .degreesBtn {
            padding-top: 35px;
        }

        #MerchandiseSingleForm .imgBox img{
            margin-top: 10px;
            margin-bottom: 15px;
            width: 230px;
            height: 280px;
        }

    </style>
@endsection

@section('content')

    @include('Components/Error')
    @include('Components/Success')

    <div id="MerchandiseSingleForm">
        <div class="row">
            <div class="col">
                <h1>商品更新</h1>
            </div>
        </div>
        <div id="ontherOption">
            <label>其他選項:</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="showDegree" checked @click="toggle($event)">
                <label class="form-check-label" for="inlineCheckbox1">度數</label>
            </div>
        </div>

        {{ Form::open(array('url' => 'merchandise/' . $products->id . '/update', 'method' => 'put', 'files' => true)) }}
        {{ Form::token() }}
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="name">商品名稱 (繁中)</label>
                    @if (old('name_tw'))
                        <input type="text" class="form-control" name='name_tw' placeholder="繁中名稱" value="{{ old('name_tw') }}">
                    @else
                        <input type="text" class="form-control" name='name_tw' placeholder="繁中名稱" value="{{ $products->name_tw }}">
                    @endif
                </div>
                <div class="col">
                    <label for="name">商品名稱 (簡中)</label>
                    @if (old('name_cn'))
                        <input type="text" class="form-control" name='name_cn' placeholder="繁中名稱" value="{{ old('name_cn') }}">
                    @else
                        <input type="text" class="form-control" name='name_cn' placeholder="繁中名稱" value="{{ $products->name_cn }}">
                    @endif
                </div>
                <div class="col">
                    <label for="name">商品名稱 (英文)</label>
                    @if (old('name_en'))
                        <input type="text" class="form-control" name='name_en' placeholder="繁中名稱" value="{{ old('name_en') }}">
                    @else
                        <input type="text" class="form-control" name='name_en' placeholder="繁中名稱" value="{{ $products->name_en }}">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="brand">品牌</label>
            @if (old('brand'))
                <input type="text" class="form-control" name='brand' placeholder="品牌" value="{{ old('brand') }}">
            @else
                <input type="text" class="form-control" name='brand' placeholder="品牌" value="{{ $products->brand }}">
            @endif
        </div>
        <div class="form-group">
            <label for="price">價格</label>
            @if (old('price'))
                <input type="number" class="form-control" name='price' placeholder="價格" value="{{ old('price') }}">
            @else
                <input type="number" class="form-control" name='price' placeholder="價格" value="{{ $products->price }}">
            @endif
        </div>
        <div class="form-group">
            <label for="remain_count">存貨</label>
            @if (old('remain_count'))
                <input type="number" class="form-control" name='remain_count' placeholder="存貨" value="{{ old('remain_count') }}">
            @else
                <input type="number" class="form-control" name='remain_count' placeholder="存貨" value="{{ $products->remain_count }}">
            @endif
        </div>
        <div class="form-group">
            <label for="status">商品狀態</label>
            <!-- 這邊結構有點亂 -->
            <!-- 有old的資料先用, 沒有就用db的 -->
            <select class="form-control" id="status" name='status'>
                @if (old('status'))
                    <option value='C'
                            @if(old('status') === 'C')
                            selected
                            @endif>
                        建立中
                    </option>
                    <option value='S'
                            @if(old('status') === 'S')
                            selected
                            @endif>可販售</option>
                @else
                    <option value='C'
                            @if ($products->status === 'C')
                            selected
                            @endif>
                        建立中
                    </option>
                    <option value='S'
                            @if ($products->status === 'S')
                            selected
                            @endif>可販售</option>
                @endif
            </select>

        </div>
        <div class="form-group">
            <label for="type">商品類型</label>
            <select class="form-control" id="catalogues" name='type'>
                <option v-for='listGroup in cataloguesGroup' :value="listGroup['id']">@{{ listGroup['type'] }}</option>
            </select>
        </div>
        <div v-show="showDegree">
            <div class="form-group">
                <label>度數</label>
                <select class="custom-select custom-select-md">
                    <option v-for='option in degreesOption'>
                        @{{ option }}
                    </option>
                </select>
                <input type="hidden" name="extra_info_degrees" value="{{ json_encode($products->extra_info['degrees']) }}"/>
            </div>
            <div class="form-row">
                <div class="form-group col-xl-6">
                    <label for="number">新增度數</label>
                    <input type="number" class="form-control" id='degreesOptionInput' value="">
                </div>
                <div class="form-group col-xl-6 degreesBtn">
                    <button @click='addDegreesOption()' class="btn btn-info btn-sm" type='button'>Add</button>
                    <button @click='resetDegreesOption()' class="btn btn-info btn-sm" type='button'>Reset</button>
                </div>
            </div>
            <input type="hidden" name="degreesOption" :value="degreesOption">
            <input type="hidden" name="oldOption" value="{{ old('degreesOption') }}">
        </div>

        <div class="form-row">
            <div class="form-group col-xl-4 imgBox">
                @if (isset($products->photos[0]))
                    <img src="{{url($products->photos[0])}}" alt="">
                @else
                    <img src="" alt="">
                @endif
                <div class="row">
                    <div class="col col-xl-2">
                        <p>1.</p>
                    </div>
                    <div class="col col-xl-10">
                        {{ Form::file('image', ['name' => 'photos1', 'multiple' => false, 'class' => 'form-control-file']) }}
                    </div>
                </div>
            </div>
            <div class="form-group col-xl-4 imgBox">
                @if (isset($products->photos[1]))
                    <img src="{{url($products->photos[1])}}" alt="">
                @else
                    <img src="" alt="">
                @endif
                <div class="row">
                    <div class="col col-xl-2">
                        <p>2.</p>
                    </div>
                    <div class="col col-xl-10">
                        {{ Form::file('image', ['name' => 'photos2', 'multiple' => false, 'class' => 'form-control-file']) }}
                    </div>
                </div>
            </div>
            <div class="form-group col-xl-4 imgBox">
                @if (isset($products->photos[2]))
                    <img src="{{url($products->photos[2])}}" alt="">
                @else
                    <img src="" alt="">
                @endif
                <div class="row">
                    <div class="col col-xl-2">
                        <p>3.</p>
                    </div>
                    <div class="col col-xl-10">
                        {{ Form::file('image', ['name' => 'photos3', 'multiple' => false, 'class' => 'form-control-file']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-xl-4 imgBox">
                @if (isset($products->photos[3]))
                    <img src="{{url($products->photos[3])}}" alt="">
                @else
                    <img src="" alt="">
                @endif
                <div class="row">
                    <div class="col col-xl-2">
                        <p>4.</p>
                    </div>
                    <div class="col col-xl-10">
                        {{ Form::file('image', ['name' => 'photos4', 'multiple' => false, 'class' => 'form-control-file']) }}
                    </div>
                </div>
            </div>
            <div class="form-group col-xl-4 imgBox">
                @if (isset($products->photos[4]))
                    <img src="{{url($products->photos[4])}}" alt="">
                @else
                    <img src="" alt="">
                @endif
                <div class="row">
                    <div class="col col-xl-2">
                        <p>5.</p>
                    </div>
                    <div class="col col-xl-10">
                        {{ Form::file('image', ['name' => 'photos5', 'multiple' => false, 'class' => 'form-control-file']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>主頁照片</label>
            <select class="custom-select custom-select-md" name="firstPhoto">
                <option name="1">1</option>
                <option name="2">2</option>
                <option name="3">3</option>
                <option name="4">4</option>
                <option name="5">5</option>
            </select>
        </div>

        <div class="form-group">
            <label for="intro_tw">介紹 (繁中) <a href="https://htmlg.com/html-editor/" target="_blank">HTML 編輯器</a> </label>
            @if (old('intro_tw'))
                <textarea class="form-control" rows="8" placeholder="英文介紹" name="intro_tw">{{ old('intro_tw') }}</textarea>
            @else
                <textarea class="form-control" rows="8" placeholder="繁中介紹" name="intro_tw">{{ $products->introduction['intro_tw'] }}</textarea>
            @endif
        </div>
        <div class="form-group">
            <label for="intro_cn">介紹 (簡中) <a href="https://htmlg.com/html-editor/" target="_blank">HTML 編輯器</a> </label>
            @if (old('intro_cn'))
                <textarea class="form-control" rows="8" placeholder="英文介紹" name="intro_cn">{{ old('intro_cn') }}</textarea>
            @else
                <textarea class="form-control" rows="8" placeholder="繁中介紹" name="intro_cn">{{ $products->introduction['intro_cn'] }}</textarea>
            @endif
        </div>
        <div class="form-group">
            <label for="intro_en">介紹 (英文) <a href="https://htmlg.com/html-editor/" target="_blank">HTML 編輯器</a> </label>
            @if (old('intro_en'))
                <textarea class="form-control" rows="8" placeholder="英文介紹" name="intro_en">{{ old('intro_en') }}</textarea>
            @else
                <textarea class="form-control" rows="8" placeholder="繁中介紹" name="intro_en">{{ $products->introduction['intro_en'] }}</textarea>
            @endif
        </div>
        <button class="btn btn-primary submitBtn" type="submit">更新</button>
        {{ Form::close() }}
    </div>

@endsection

@section('script')
    @parent
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script type="text/javascript">
        const MerchandiseSingleForm = new Vue({
            el: '#MerchandiseSingleForm',

            data: {
                showDegree: true,

                degreesOption: [],

                cataloguesGroup: [],
            },

            mounted() {
                let self = this;
                let oldOptionVal = $('input[name=oldOption]').val();

                // 先用old的資料, 沒有就用db的
                if (oldOptionVal !== "") {
                    this.degreesOption = oldOptionVal.split(',');
                } else {
                    this.degreesOption = JSON.parse($("input[name=extra_info_degrees]").val());
                }

                axios.get('/merchandise/api/getCataloguesListDatasSubGroup')
                    .then(function (response) {
                        console.log(response);
                        if (response.data.result !== true) {
                            console.log(response.data.errorCode);

                            return;
                        }

                        self.cataloguesGroup = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            methods: {
                toggle: function(event) {
                    switch (event.currentTarget.value) {
                        case 'showDegree':
                            this.showDegree = !this.showDegree;
                            break;
                    }
                },

                addDegreesOption: function() {

                    this.degreesOption.push(parseInt($('#degreesOptionInput').val()));
                    // clear old
                    $('#degreesOptionInput').val("");
                },

                resetDegreesOption: function() {
                    this.degreesOption = [];
                },
            },
        });
    </script>
@endsection