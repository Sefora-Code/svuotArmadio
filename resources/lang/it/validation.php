<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => '  :attribute deve essere accepted.',
    'active_url' => '  :attribute is not a valid URL.',
    'after' => '  :attribute deve essere a date after :date.',
    'after_or_equal' => '  :attribute deve essere a date after or equal to :date.',
    'alpha' => '  :attribute must only contain letters.',
    'alpha_dash' => '  :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => '  :attribute must only contain letters and numbers.',
    'array' => '  :attribute deve essere an array.',
    'before' => '  :attribute deve essere a date before :date.',
    'before_or_equal' => '  :attribute deve essere a date before or equal to :date.',
    'between' => [
        'numeric' => '  :attribute deve essere between :min and :max.',
        'file' => '  :attribute deve essere between :min and :max kilobytes.',
        'string' => '  :attribute deve essere between :min and :max caratteri.',
        'array' => '  :attribute must have between :min and :max items.',
    ],
    'boolean' => '  :attribute field deve essere true or false.',
    'confirmed' => '  :attribute non coincide.',
    'current_password' => '  password is incorrect.',
    'date' => '  :attribute is not a valid date.',
    'date_equals' => '  :attribute deve essere a date equal to :date.',
    'date_format' => '  :attribute does not match the format :format.',
    'different' => '  :attribute and :other deve essere different.',
    'digits' => '  :attribute deve essere :digits digits.',
    'digits_between' => '  :attribute deve essere between :min and :max digits.',
    'dimensions' => '  :attribute has invalid image dimensions.',
    'distinct' => '  :attribute field has a duplicate value.',
    'email' => '  :attribute deve essere a valid email address.',
    'ends_with' => '  :attribute must end with one of the following: :values.',
    'exists' => '  selected :attribute is invalid.',
    'file' => '  :attribute deve essere a file.',
    'filled' => '  :attribute field must have a value.',
    'gt' => [
        'numeric' => '  :attribute deve essere greater than :value.',
        'file' => '  :attribute deve essere greater than :value kilobytes.',
        'string' => '  :attribute deve essere greater than :value caratteri.',
        'array' => '  :attribute must avere più di :value items.',
    ],
    'gte' => [
        'numeric' => '  :attribute deve essere greater than or equal :value.',
        'file' => '  :attribute deve essere greater than or equal :value kilobytes.',
        'string' => '  :attribute deve essere greater than or equal :value caratteri.',
        'array' => '  :attribute must have :value items or more.',
    ],
    'image' => '  :attribute deve essere an image.',
    'in' => '  selected :attribute is invalid.',
    'in_array' => '  :attribute field does not exist in :other.',
    'integer' => '  :attribute deve essere an integer.',
    'ip' => '  :attribute deve essere a valid IP address.',
    'ipv4' => '  :attribute deve essere a valid IPv4 address.',
    'ipv6' => '  :attribute deve essere a valid IPv6 address.',
    'json' => '  :attribute deve essere a valid JSON string.',
    'lt' => [
        'numeric' => '  :attribute deve essere less than :value.',
        'file' => '  :attribute deve essere less than :value kilobytes.',
        'string' => '  :attribute deve essere less than :value caratteri.',
        'array' => '  :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => '  :attribute deve essere meno di o uguale a :value.',
        'file' => '  :attribute deve essere meno di o uguale a :value kilobytes.',
        'string' => '  :attribute deve essere meno di o uguale a :value caratteri.',
        'array' => '  :attribute non deve avere più di :value items.',
    ],
    'max' => [
        'numeric' => '  :attribute non deve essere piú lunga di :max.',
        'file' => '  :attribute non deve essere piú lunga di :max kilobytes.',
        'string' => '  :attribute non deve essere piú lunga di :max caratteri.',
        'array' => '  :attribute non deve avere più di :max items.',
    ],
    'mimes' => '  :attribute deve essere a file of type: :values.',
    'mimetypes' => '  :attribute deve essere a file of type: :values.',
    'min' => [
        'numeric' => '  :attribute deve essere almeno :min.',
        'file' => '  :attribute deve essere almeno :min kilobytes.',
        'string' => 'La :attribute deve essere almeno :min caratteri.',
        'array' => '  :attribute must have almeno :min items.',
    ],
    'multiple_of' => '  :attribute deve essere a multiple of :value.',
    'not_in' => '  selected :attribute is invalid.',
    'not_regex' => '  :attribute format is invalid.',
    'numeric' => '  :attribute deve essere a number.',
    'password' => '  password is incorrect.',
    'present' => '  :attribute field deve essere present.',
    'regex' => '  :attribute format is invalid.',
    'required' => '  :attribute field is required.',
    'required_if' => '  :attribute field is required when :other is :value.',
    'required_unless' => '  :attribute field is required unless :other is in :values.',
    'required_with' => '  :attribute field is required when :values is present.',
    'required_with_all' => '  :attribute field is required when :values are present.',
    'required_without' => '  :attribute field is required when :values is not present.',
    'required_without_all' => '  :attribute field is required when none of :values are present.',
    'prohibited' => '  :attribute field is prohibited.',
    'prohibited_if' => '  :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => '  :attribute field is prohibited unless :other is in :values.',
    'same' => '  :attribute and :other must match.',
    'size' => [
        'numeric' => '  :attribute deve essere :size.',
        'file' => '  :attribute deve essere :size kilobytes.',
        'string' => '  :attribute deve essere :size caratteri.',
        'array' => '  :attribute deve contenere :size items.',
    ],
    'starts_with' => '  :attribute must start with one of the following: :values.',
    'string' => '  :attribute deve essere a string.',
    'timezone' => '  :attribute deve essere a valid zone.',
    'unique' => '  :attribute has already been taken.',
    'uploaded' => '  :attribute failed to upload.',
    'url' => '  :attribute format is invalid.',
    'uuid' => '  :attribute deve essere a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
