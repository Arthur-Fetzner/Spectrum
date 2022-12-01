import os
import cv2
import numpy as np
import tensorflow
from keras.models import load_model

model = load_model("C:/xampp/htdocs/Spectrum/python/modelo_02_expressoes.h5")
expressoes = ["Raiva", "Nojo", "Medo", "Feliz", "Triste", "Surpreso", "Neutro"]

def detectar(imagem, larquivo): 
    
    gray = cv2.cvtColor(imagem, cv2.COLOR_BGR2GRAY)
    face_cascade = cv2.CascadeClassifier('C:/xampp/htdocs/Spectrum/python/haarcascade_frontalface_default.xml')
    faces = face_cascade.detectMultiScale(gray, 1.1, 3)
    for (x, y, w, h) in faces:
        cv2.rectangle(imagem, (x, y), (x + w, y + h), (0, 255, 0), 1)
        roi_gray = gray[y:y + h, x:x + w]
        roi_gray = roi_gray.astype("float") / 255.0
        cropped_img = np.expand_dims(np.expand_dims(cv2.resize(roi_gray, (48, 48)), -1), 0)
        cv2.normalize(cropped_img, cropped_img, alpha=0, beta=1, 
                      norm_type=cv2.NORM_L2, dtype=cv2.CV_32F)
        prediction = model.predict(cropped_img)[0]
        
        #Quanto deu em cada emoção
        print(prediction)
        
        prediction = expressoes[int(np.argmax(prediction))]
        
        #Posição X Y W H de cada detecção
        #print('x: ' + str(x) + ' y: ' + str(y) + ' w: ' + str(w) +' h: ' + str(h))
        
        #print(prediction)
        #print(path)
        nome = []

        for caractere in larquivo:
            if caractere.isdigit():
                nome.append(caractere)
        nome = "".join(nome)

        arquivo = open("C:/xampp/htdocs/Spectrum/arquivos/resultados/"+str(nome)+".txt", "a")
        arquivo.write(prediction)
        arquivo.write('\n')
        arquivo.write('x: ' + str(x) + ' y: ' + str(y) + ' w: ' + str(w) +' h: ' + str(h))
        arquivo.write('\n')

    os.replace("C:/xampp/htdocs/Spectrum/arquivos/a fazer/"+str(larquivo), "C:/xampp/htdocs/Spectrum/arquivos/feitos/"+str(larquivo))
        
def img_video(imagem_ou_video, path, arquivo):
    if imagem_ou_video == 'imagem':
        imagem = cv2.imread(path)
        detectar(imagem, arquivo)
    else:
        video = cv2.VideoCapture(path)
        while True: 
            ret, imagem = video.read()
            if ret == False:
                break
            else:
                detectar(imagem)

#passar 'imagem' ou  'video' e o path do arquivo
#img_video('video', 'video.mp4')

pasta = 'C:/xampp/htdocs/Spectrum/arquivos/a fazer'

while True:
    for diretorio, subpastas, arquivos in os.walk(pasta):
        for arquivo in arquivos:
            link = os.path.join(diretorio, arquivo)
            print(link)
            print(arquivo)
            img_video('imagem', link, arquivo)