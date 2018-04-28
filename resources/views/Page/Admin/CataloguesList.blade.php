@extends('Page/Admin/App')

@section('title', $title)

@section('style')
@parent
<style>
    #catalogues {
        padding-left: 20px;
        padding-top: 10px;
    }
    
    #catalogues .mainType {
        font-size: 35px;
    }
    
    #catalogues .subType {
        font-size: 20px;

    }
    
    #catalogues .cataloguesList {
        margin-top: 20px;
        padding-left: 25px;
    }
    
    #catalogues .cataloguesBtnList {
        margin-top: 5px;
    }
    
    #catalogues .lgX {
        color: red;
        font-size: 25px;
    }
    
    #catalogues .smX {
        color: red;
        font-size: 15px;
    }    
</style>
@endsection

@section('content')

<div id="catalogues">
    <div class="row">
        <div class="col">
            <h1>商品目錄管理</h1>
        </div>
    </div>
    <div class="row cataloguesList">
        <div class="col col-xl-3">
            <div class="mainType" v-for="mainData in catalogues" v-if="mainData['parents'] == 0">
                @{{ mainData['type'] }}
                <li class="subType" v-for="subData in catalogues" v-if="subData['parents'] == mainData['id']">
                    @{{ subData['type'] }}
                </li>                        
            </div>
        </div>
        <div class="col cataloguesBtnList">
            
            <div class="form-group">
              <label>新增主大類:</label>
              <div class="row">
                  <div class="col col-xl-4">
                      <input type="text" name="mainType" class="form-control">
                  </div>
                  <div class="col">
                      <div class="btn btn-info" @click="addMainType()">
                          新增
                      </div>
                  </div>
              </div>
            </div>
            
            <div class="form-group">
              <label>新增子類別:</label>
              <div class="row">
                  <div class="col col-xl-3">
                    <select name='parents' class="custom-select custom-select-md">
                      <option value="-1"></option> 
                      <option v-for="data in catalogues" v-if="data['parents'] == 0" :value="data['id']">@{{ data['type'] }}</option>
                    </select>                      
                  </div>
                  <div class="col col-xl-4">
                      <input type="text" name="subType" class="form-control">
                  </div>
                  <div class="col">
                      <div class="btn btn-info" @click="addSubType()">
                          新增
                      </div>
                  </div>
              </div>
            </div>
            
            <div class="form-group">
              <label>刪除類別:</label> 
              <div class="row">
                  <div class="col col-xl-3">
                    <select name='deleteType' class="custom-select custom-select-md">
                      <option value="-1"></option>    
                      <option v-for="data in cataloguesGroup" :value="data['id']">@{{ data['type'] }}</option>
                    </select>                      
                  </div>
                  <div class="col">
                      <div class="btn btn-info" @click="deleteType()">
                          刪除
                      </div>
                  </div>
              </div>
            </div> 
            
            <div class="form-group">
              <label>修改名稱:</label> 
              <div class="row">
                  <div class="col col-xl-3">
                    <select name='changeNameId' class="custom-select custom-select-md">
                      <option value="-1"></option>    
                      <option v-for="data in catalogues" :value="data['id']">@{{ data['type'] }}</option>
                    </select>                      
                  </div>
                  <div class="col col-xl-4">
                      <input type="text" name="changeNameInput" class="form-control">
                  </div>                  
                  <div class="col">
                      <div class="btn btn-info" @click="changeName()">
                          更新
                      </div>
                  </div>
              </div>
            </div>             
        </div>
    </div>

</div>

@endsection

@section('script')
@parent
<script type="text/javascript">
    const catalogues = new Vue({
        el: "#catalogues",
        
        data: {
            catalogues: [],
            
            cataloguesGroup: [],
        },
        
        mounted() {
            let self = this;
            
            axios.get('/merchandise/api/getCataloguesListDatas')
            .then(function (response) {
                if (response.data.result !== true) {
                    console.log(response.data.errorCode);
                    
                    return;
                }
                
                self.catalogues = response.data.data;
            })
            .catch(function (error) {
                console.log(error);
            });
            
            axios.get('/merchandise/api/getCataloguesListDatasGroup')
            .then(function (response) {
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
            addMainType() {
                let self = this;
                
                let data = {
                    'type': $('input[name=mainType]').val(),
                };
                
                axios.post('/merchandise/api/addMainType', data)
                .then(function (response) {
                    if (response.data.result !== true) {
                        console.log(response.data.errorCode);
                        
                        return;
                    }
                    
                    self.cataloguesGroup = response.data.data['groupList'];
                    self.catalogues = response.data.data['list'];
                    $('input[name=mainType]').val("");
                })
                .catch(function (error) {
                    console.log(error);
                });                
            },
            
            addSubType() {
                let self = this;
                
                let data = {
                    'type': $('input[name=subType]').val(),
                    'parents': $('select[name=parents]').val(),
                };
                
                axios.post('/merchandise/api/addSubType', data)
                .then(function (response) {
                    if (response.data.result !== true) {
                        console.log(response.data.errorCode);
                        
                        return;
                    }
                    
                    self.cataloguesGroup = response.data.data['groupList'];
                    self.catalogues = response.data.data['list'];
                    $('input[name=subType]').val("");
                })
                .catch(function (error) {
                    console.log(error);
                });                  
            },
            
            deleteType() {
                var r = confirm("確認要刪除嗎?");
                
                if (r !== true) {
                    
                    return;
                }
                
                let self = this;
                let id = $('select[name=deleteType]').val();
                
                axios.delete('/merchandise/api/deleteType/' + id)
                .then(function (response) {
                    console.log(response);
                    if (response.data.result !== true) {
                        console.log(response.data.errorCode);
                        
                        return;
                    }
                    
                    self.cataloguesGroup = response.data.data['groupList'];
                    self.catalogues = response.data.data['list'];
                })
                .catch(function (error) {
                    console.log(error);
                });                 
            },
            
            changeName() {
                let self = this;
                
                let data = {
                    'id': $('select[name=changeNameId]').val(),
                    'type': $('input[name=changeNameInput]').val(),
                };
                console.log(data);
                axios.put('/merchandise/api/changeTypeName', data)
                .then(function (response) {
                    if (response.data.result !== true) {
                        console.log(response.data.errorCode);
                        
                        return;
                    }
                    
                    self.cataloguesGroup = response.data.data['groupList'];
                    self.catalogues = response.data.data['list'];
                    $('input[name=changeNameInput]').val("");
                })
                .catch(function (error) {
                    console.log(error);
                });                   
            }
        }
    });
</script>
@endsection


