rmdir sony /S /Q
mkdir sony
robocopy ..\css .\sony\css /S
robocopy ..\fonts .\sony\fonts /S
robocopy ..\images .\sony\images /S
robocopy ..\js .\sony\js /S
robocopy ..\..\common\json .\sony\json /S
robocopy ..\webinitiator .\sony\webinitiator /S

copy ..\index.html .\sony\index.html
cd sony