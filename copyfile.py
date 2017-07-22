# -*- coding:utf-8 -*-
import json, os, shutil
from sys import argv

rootpath = os.getcwd() + '/'
config = json.loads(open("file.json").read())


def backupFile(filePath):
    srcPath = rootpath + filePath
    dstPath = rootpath + config['bakPath'] + filePath
    dstPathDir = os.path.dirname(dstPath)
    if (not os.path.exists(dstPathDir)):
        os.makedirs(dstPathDir)
    try:
        shutil.copyfile(srcPath, dstPath)
        print "Backup file : " + filePath + ". Done!"
    except Exception, e:
        print e


def copyFile(filePath):
    srcPath = rootpath + config['pluginPath'] + filePath
    dstPath = rootpath + filePath
    dstPathDir = os.path.dirname(dstPath)
    if (not os.path.exists(dstPathDir)):
        os.makedirs(dstPathDir)
    try:
        shutil.copyfile(srcPath, dstPath)
        print "Copy & Overwrite file : " + filePath + ". Done!"
    except Exception, e:
        print e


def getFileList(Path):
    fileList = getFiles(Path)
    result = []
    for item in fileList:
        result.append(item.replace(Path, ""))
    return result


def getFiles(path):
    filelist = os.listdir(path)
    result = []
    for filename in filelist:
        filepath = os.path.join(path, filename)
        if os.path.isdir(filepath):
            result.extend(getFiles(filepath))
        else:
            result.append(filepath)
    return result


def main():
    # shutil.rmtree(rootpath + config['bakPath'])
    print "Backup directory clear!"
    # for item in getFileList(rootpath + config['bakPath']):
    #     backupFile(item)
    for item in getFileList(rootpath + config['pluginPath']):
        copyFile(item)
main()
