## 说明

> 这是一个Laravel的拓展项目

#### 需求
项目中使用`is_enabled`来控制本条消息是否有效。

## 使用

### 下载
```text
composer require sollyu/laravel-model-enabled
```

### 使用

在`Model`中使用`IsEnabled`即可，代码示例

```php
use Sollyu\IsEnabled\IsEnabled;

class User extends Model
{
    use IsEnabled;
    
    # 重新定义字段名称（默认为：is_enabled）
    const IS_ENABLED = 'enabled';
}
```

migrate内容
```php
$table->boolean('is_enabled')->default(1);
```

## 方法

```php
# 包含被禁用的数据查询
User::withDisabled()

# 只查询被禁用的数据
User::onlyDisabled()

# 修改禁用\启用
$user = new User;
$user->enable();    # 启用
$user->disable();   # 禁用
$user->save();      # 保存
```

## LICENSE

```text
Copyright 2018 Sollyu

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```