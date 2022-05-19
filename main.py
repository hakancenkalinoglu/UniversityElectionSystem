import pyexcel as pe

import excel_writer

ROW = 22

FACULTY_LIST = []
UNI_NAME = []
FACULTY_NAME = []
UNIVERSITY_LIST = []
PROGRAM_CODE = []
PROGRAM_NAME = []
TABAN_PUANI = []
BIRINCI_KONT = []
KONTENJAN = []
BASARI_SIRASI = []
PUAN_TURU = []
OGR_SURE = []
DESC = []


def has_numbers(inputString):
    return any(char.isdigit() for char in inputString)


filename = "2021_4.xls"
records = pe.get_array(file_name=filename)

for i in range(len(records)):
    if len(records[i][0]) == 0:
        if ("Fakülte" or "Yüksekokulu") in records[i][1]:
            if not records[i][1] in FACULTY_LIST:
                FACULTY_LIST.append(records[i][1])  # ünik yapıyor
        if "Üniversite" in records[i][1]:
            if not records[i][1] in UNIVERSITY_LIST:
                UNIVERSITY_LIST.append(records[i][1])  # ünik yapıyor


    else:
        OGR_SURE.append(records[i][2])
        PUAN_TURU.append(records[i][3])
        KONTENJAN.append(records[i][4])
        BIRINCI_KONT.append(records[i][5])
        DESC.append(records[i][6])
        BASARI_SIRASI.append(records[i][8])
        TABAN_PUANI.append(records[i][9])

for i in range(len(records)):
    if len(records[i][0]) == 0:
        if records[i][1] in UNIVERSITY_LIST:
            uni = records[i][1]
        elif records[i][1] in FACULTY_LIST:
            if 'uni' in vars():
                UNI_NAME.append(uni)
            FACULTY_NAME.append(records[i][1])

OGR_SURE = [int(i) for i in OGR_SURE[2:]]
PUAN_TURU = PUAN_TURU[2:]
FACULTY_LIST = FACULTY_LIST[1:]
KONTENJAN = [int(i) for i in KONTENJAN[2:]]
# BIRINCI_KONT = [int(i) for i in BIRINCI_KONT[2:]]
DESC = DESC[2:]
# BASARI_SIRASI = [int(i) for i in BASARI_SIRASI[2:]]
# TABAN_PUANI = [float(i) for i in TABAN_PUANI[2:]]


excel_writer.excel_write("university.xls", UNIVERSITY_LIST, title="uni_id", title2="uni_name")
excel_writer.excel_write("faculty_name.xls", FACULTY_LIST, title="faculty_name_id", title2="faculty_name")
excel_writer.excel_write("uni_faculty_name.xls", UNI_NAME, title="uni_name", title2="faculty_name", content2=FACULTY_NAME)
excel_writer.merge()
# excel_writer.excel_write_fk("faculty.xls", id, id2, title="faculty_id", title2="uni_id")


# TODO EXCELI YAZ
