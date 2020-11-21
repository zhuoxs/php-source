1、打包的时候请注意，不要把protobuf下的proto文件夹放到php-sdk的包中；
2、编译proto的时候，php版本我们有个专门的工程可以来编译这个 ，工程名称：sdk-protobuf
3、包不要包含.git，.gitignore等与本身无关的内容