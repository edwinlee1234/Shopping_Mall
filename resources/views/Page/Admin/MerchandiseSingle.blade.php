@extends('Page/Admin/App')

@section('title', $title)

@section('style')
@parent
<style>
  #MerchandiseSingleForm {
      width: 800px;
  }
</style>
@endsection

@section('content')

<br>
@include('Components/Error')
@include('Components/Success')

<div id="MerchandiseSingleForm">
    
    <div id="ontherOption">
        <label>其他選項:</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="showDegree" checked @click="toggle($event)">
            <label class="form-check-label" for="inlineCheckbox1">度數</label>
        </div>        
    </div>

    {{ Form::open(array('url' => 'merchandise/create', 'method' => 'post', 'files' => true)) }}
        {{ Form::token() }}
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="name">商品名稱 (繁中)</label>
                    <input type="text" class="form-control" name='name_tw' placeholder="繁中名稱" value="{{ old('name_tw') }}">
                </div>
                <div class="col">
                    <label for="name">商品名稱 (簡中)</label>
                    <input type="text" class="form-control" name='name_ch' placeholder="簡中名稱" value="{{ old('name_ch') }}">
                </div>
                <div class="col">
                    <label for="name">商品名稱 (英文)</label>
                    <input type="text" class="form-control" name='name_en' placeholder="英文名稱" value="{{ old('name_en') }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="brand">品牌</label>
            <input type="text" class="form-control" name='brand' placeholder="品牌" value="{{ old('brand') }}">
        </div>
        <div class="form-group">
            <label for="price">價格</label>
            <input type="text" class="form-control" name='price' placeholder="價格" value="{{ old('price') }}">
        </div>            
        <div class="form-group">
            <label for="remain_count">存貨</label>
            <input type="text" class="form-control" name='remain_count' placeholder="存貨" value="{{ old('remain_count') }}">
        </div>            
        <div class="form-group">
            <label for="status">商品狀態</label>
            <select class="form-control" id="status" name='status'>
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
            </select>
        </div>

        <div v-show="showDegree" class="form-group">
            <label for="status">度數</label>
            <select>
                <option v-for='option in degreesOption'>
                    @{{ option }}
                </option>
            </select>
            <input type="number" class="form-control" id='degreesOptionInput' value="">
            <button @click='addDegreesOption()' class="btn btn-info btn-sm" type='button'>Add</button>
            <button @click='resetDegreesOption()' class="btn btn-info btn-sm" type='button'>Reset</button>
            <input type="hidden" name="degreesOption" :value="degreesOption">
            <input type="hidden" name="oldOption" value="{{ old('degreesOption') }}">
        </div>
        <div class="form-group">
            <label for="photo">圖片</label>
            {{ Form::file('image', ['name' => 'photo', 'multiple' => true, 'class' => 'form-control-file']) }}
        </div>
        <div class="form-group">
            <label for="intro_tw">介紹 (繁中)</label>
            <textarea class="form-control" rows="5" placeholder="繁中介紹" name="intro_tw">{{ old('intro_tw') }}</textarea>
        </div>
        <div class="form-group">
            <label for="intro_ch">介紹 (簡中)</label>
            <textarea class="form-control" rows="5" placeholder="簡中介紹" name="intro_ch">{{ old('intro_ch') }}</textarea>
        </div>
        <div class="form-group">
            <label for="intro_en">介紹 (英文)</label>
            <textarea class="form-control" rows="5" placeholder="英文介紹" name="intro_en">{{ old('intro_en') }}</textarea>
        </div>
        <br>
        <button class="btn btn-primary" type="submit">提交</button>
    {{ Form::close() }}  
</div>

@endsection

@section('script')
@parent
<script type="text/javascript">
    const MerchandiseSingleForm = new Vue({
        el: '#MerchandiseSingleForm',
        
        mounted() {
            let oldOptionVal = $('input[name=oldOption]').val();

            if (oldOptionVal !== "") {
                this.degreesOption = oldOptionVal.split(',');
            }
        },
        
        data: {
            showDegree: true,
            
            degreesOption: [],
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
                  this.degreesOption.push($('#degreesOptionInput').val());
              },
              
              resetDegreesOption: function() {
                  this.degreesOption = [];
              },
        },
    });
</script>
@endsection