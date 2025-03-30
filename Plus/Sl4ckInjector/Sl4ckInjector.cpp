#include <Windows.h>
#include <iostream>
#include <TlHelp32.h>

DWORD get_proc_id(const wchar_t* proc_name)
{
    DWORD proc_id = 0;
    auto* const h_snap = CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);

    if (h_snap != INVALID_HANDLE_VALUE)
    {
        PROCESSENTRY32W proc_entry;
        proc_entry.dwSize = sizeof(proc_entry);

        if (Process32FirstW(h_snap, &proc_entry))
        {
            do
            {
                if (!_wcsicmp(proc_entry.szExeFile, proc_name))
                {
                    proc_id = proc_entry.th32ProcessID;
                    break;
                }
            } while (Process32NextW(h_snap, &proc_entry));
        }
    }

    CloseHandle(h_snap);
    return proc_id;
}

int main(int argc, char* argv[])
{
    std::string word = (argc > 1) ? argv[1] : "";
    std::wstring w_word(word.begin(), word.end());

    wchar_t szPath[MAX_PATH];
    GetFullPathNameW(L"C:\\GalaxyInjector\\test.dll", MAX_PATH, szPath, nullptr);
    const wchar_t* proc_name = w_word.c_str();
    DWORD proc_id = 0;

    while (!proc_id)
    {
        proc_id = get_proc_id(proc_name);
        Sleep(30);
    }

    auto* const h_proc = OpenProcess(PROCESS_ALL_ACCESS, 0, proc_id);

    if (h_proc != INVALID_HANDLE_VALUE)
    {
        const LPVOID nt_open_file = GetProcAddress(LoadLibraryA("ntdll"), "NtOpenFile");
        if (nt_open_file)
        {
            char original_bytes[5];
            memcpy(original_bytes, nt_open_file, 5);
            WriteProcessMemory(h_proc, nt_open_file, original_bytes, 5, nullptr);
        }

        auto* loc = VirtualAllocEx(h_proc, nullptr, MAX_PATH * sizeof(wchar_t), MEM_COMMIT | MEM_RESERVE, PAGE_READWRITE);
        WriteProcessMemory(h_proc, loc, szPath, (wcslen(szPath) + 1) * sizeof(wchar_t), nullptr);
        auto* const h_thread = CreateRemoteThread(h_proc, nullptr, 0, reinterpret_cast<LPTHREAD_START_ROUTINE>(LoadLibraryW), loc, 0, nullptr);

        if (h_thread) CloseHandle(h_thread);
    }

    if (h_proc) CloseHandle(h_proc);

    if (h_proc == NULL) {
        std::wcout << "Failed to open process!" << std::endl;
        return 1;
    }
    std::wcout << L"Loading DLL from: " << szPath << std::endl;
    Sleep(3000);
    return 0;
}