rmdir sony /S /Q
mkdir sony
robocopy ..\css .\sony\css /S
robocopy ..\fonts .\sony\fonts /S
robocopy ..\images .\sony\images /S
robocopy ..\..\common\js .\sony\js /S
robocopy ..\js .\sony\js /S
robocopy ..\webinitiator .\sony\webinitiator /S

mkdir sony\conf
copy ..\index.html .\sony\index.html
cd sony